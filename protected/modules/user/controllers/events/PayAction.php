<?php
namespace user\controllers\events;

use event\models\Event;
use pay\components\Exception as PayException;
use pay\components\OrderItemCollection;
use pay\models\Order;
use pay\models\OrderItem;
use pay\models\OrderType;
use pay\models\Product;

class PayAction extends \CAction
{
    public function run()
    {
        $user = \Yii::app()->getUser()->getCurrentUser();

        $criteria = clone OrderItem::model()->byPayerId($user->Id)->byDeleted(false)->with(
            ['Product', 'Product.Event', 'OrderLinks' => ['with' => ['Order'], 'together' => false]]
        )->orderBy('"t"."CreationTime"')->getDbCriteria();

        $waitOrderItems = OrderItem::model()->byPaid(false)->findAll($criteria);
        $paidOrderItems = OrderItem::model()->byPaid(true)->findAll($criteria);

        $this->getController()->render('pay', [
            'wait' => $this->getData($waitOrderItems),
            'paid' => $this->getData($paidOrderItems)
        ]);
    }

    /**
     * @param OrderItem[] $orderItems
     * @return OrderItemCollection[]
     */
    private function getData($orderItems)
    {
        /** @var EventPayItem[] $result */
        $result = [];
        foreach ($orderItems as $orderItem) {
            $event = $orderItem->Product->Event;
            $id = $event->Id;

            try {
                if ($orderItem->getPriceDiscount() == 0 || (!$orderItem->Paid && $event->getTimeStampEndDate() < time())) {
                    continue;
                }
            } catch (PayException $e) {
                continue;
            }

            if (!isset($result[$id])) {
                $result[$id] = new EventPayItem($event);
            }
            $result[$id]->pushProduct($orderItem);

            foreach ($orderItem->OrderLinks as $link) {
                $order = $link->Order;
                if ($order->Deleted) {
                    continue;
                }
                if (OrderType::getIsLong($order->Type)) {
                    $result[$id]->pushOrder($order);
                }
            }
        }
        usort($result, function (EventPayItem $item1, EventPayItem $item2) {
            if ($item1->getEvent()->getTimeStampStartDate() == $item2->getEvent()->getTimeStampStartDate()) {
                return 0;
            }
            return $item1->getEvent()->getTimeStampStartDate() > $item2->getEvent()->getTimeStampStartDate() ? -1 : 1;
        });

        return $result;
    }
}

/**
 * Class EventPayItem
 * @package user\controllers\events
 */
class EventPayItem
{
    /** @var Event */
    private $event;

    /** @var Order[] */
    private $orders = [];

    /** @var EventPayItemProduct[] */
    private $products = [];

    /**
     * @param Event $event
     */
    function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * @param OrderItem $orderItem
     */
    public function pushProduct(OrderItem $orderItem)
    {
        $product = $orderItem->Product;
        if (!isset($this->products[$product->Id])) {
            $this->products[$product->Id] = new EventPayItemProduct($product, $orderItem);
        }

        $this->products[$product->Id]->Count += $product->getManager()->getCount($orderItem);
        $this->products[$product->Id]->Total += $orderItem->getPriceDiscount();;
    }

    /**
     * @param Order $order
     */
    public function pushOrder(Order $order)
    {
        if (!isset($this->orders[$order->Id])) {
            $this->orders[$order->Id] = $order;
        }
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @return Order[]
     */
    public function getOrders()
    {
        ksort($this->orders);
        return $this->orders;
    }

    /**
     * @return EventPayItemProduct[]
     */
    public function getProducts()
    {
        return $this->products;
    }
}

class EventPayItemProduct
{
    /** @var string */
    public $Title;

    /** @var int */
    public $Count = 0;

    /** @var int */
    public $Total = 0;

    /**
     * @param Product $product
     * @param OrderItem $orderItem
     */
    function __construct(Product $product, OrderItem $orderItem)
    {
        $this->Title = $product->getManager()->getTitle($orderItem);
    }

}