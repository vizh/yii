<?php
namespace partner\controllers\main;

use application\components\helpers\ArrayHelper;
use pay\components\OrderItemCollection;
use pay\models\OrderItem;
use pay\models\OrderType;
use pay\models\Product;

class PayAction extends \partner\components\Action
{
    /** @var PayStatistics */
    public $statistics;

    public function run()
    {
        ini_set("memory_limit", "512M");
//        $oldStatistics = $this->getOldStatistics();

        $this->statistics = new PayStatistics();

        $this->statistics->countParticipants = \user\models\User::model()->byEventId($this->getEvent()->Id)->count();

        $this->fill('Juridical');
        $this->fill('Receipt');
        $this->fill('PaySystem');
        $this->fill('Paypal');
        $this->fillTotalUsers();

        $productStatistics = $this->getProductStatistics();

        $this->getController()->render('pay', [
            'statistics' => $this->statistics,
            'oldStatistics' => null,
            'productStatistics' => $productStatistics,
            'event' => $this->getEvent()
        ]);
    }

    private function fill($type)
    {
        $types = [
            'Juridical' => OrderType::Juridical,
            'Receipt' => OrderType::Receipt,
            'PaySystem' => OrderType::PaySystem,
            'Paypal' => OrderType::PaySystem
        ];

        $orders = \pay\models\Order::model()
            ->byDeleted(false)
            ->byEventId($this->getEvent()->Id)
            ->byType($types[$type], true)
            ->with('ItemLinks.OrderItem');

        $criteria = new \CDbCriteria();
        $criteria->addCondition('not "OrderItem"."Deleted"');
        if ($type == 'Paypal') {
            $criteria->addCondition('"System" = \'paypal\'');
        }
        if ($type == 'PaySystem') {
            $criteria->addCondition('"System" is null or "System" != \'paypal\'');
        }
        $orders = $orders->findAll($criteria);

        $this->statistics->{'total'.$type} = array_reduce($orders, function ($carry, $order) {
            return $carry + $order->price;
        }, 0);
        $this->statistics->{'count'.$type.'Orders'} = count($orders);

        $this->statistics->{'totalPaid'.$type} = array_reduce($orders, function ($carry, $order) {
            return $order->Paid ? $carry + $order->price : $carry;
        }, 0);
        $this->statistics->{'countPaid'.$type.'Orders'} = array_reduce($orders, function ($carry, $order) {
            return $order->Paid ? $carry + 1 : $carry;
        }, 0);

        $this->statistics->{'count'.$type.'Users'} = array_reduce($orders, function ($carry, $order) {
            return $carry + count($order->ItemLinks);
        }, 0);
        $this->statistics->{'countPaid'.$type.'Users'} = array_reduce($orders, function ($carry, $order) {
            return $order->Paid ? $carry + count($order->ItemLinks) : $carry;
        }, 0);
    }

    private function fillTotalUsers()
    {
        $command = \Yii::app()->getDb()->createCommand()
            ->select('count(DISTINCT "oi"."OwnerId") as "countUsers"')
            ->from('PayOrder o')
            ->leftJoin('PayOrderLinkOrderItem oloi', '"oloi"."OrderId" = "o"."Id"')
            ->leftJoin('PayOrderItem oi', '"oloi"."OrderItemId" = "oi"."Id"')
            ->where('"o"."EventId" = :EventId AND "o"."Paid" and NOT "o"."Deleted"');
        $command->bindValue('EventId', $this->getEvent()->Id);
        $result = $command->queryRow();

        $this->statistics->totalUsers = $result['countUsers'];

        $command = \Yii::app()->getDb()->createCommand()
            ->select('count(DISTINCT "oi"."OwnerId") as "countUsers"')
            ->from('PayOrder o')
            ->leftJoin('PayOrderLinkOrderItem oloi', '"oloi"."OrderId" = "o"."Id"')
            ->leftJoin('PayOrderItem oi', '"oloi"."OrderItemId" = "oi"."Id"')
            ->where('"o"."EventId" = :EventId and not "o"."Deleted" AND "o"."Paid"');
        $command->bindValue('EventId', $this->getEvent()->Id);
        $result = $command->queryRow();

        $this->statistics->totalPaidUsers = $result['countUsers'];

        $command = \Yii::app()->getDb()->createCommand()
            ->select('count(DISTINCT "ca"."UserId") as "countUsers"')
            ->from('PayCouponActivation ca')
            ->leftJoin('PayCoupon c', '"ca"."CouponId" = "c"."Id"')
            ->where('"c"."EventId" = :EventId AND ("c"."ManagerName" = :DiscountManagerName AND "c"."Discount" = 100)');
        $command->bindValue('EventId', $this->getEvent()->Id);
        $command->bindValue('DiscountManagerName', 'Percent');
        $result = $command->queryRow();

        $this->statistics->totalPromoUsers = $result['countUsers'];
    }

    private function getProductStatistics()
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('t."ManagerName" != :ManagerName');
        $criteria->params = ['ManagerName' => 'RoomProductManager'];

        $products = Product::model()->byEventId($this->getEvent()->Id)->ordered()->findAll($criteria);
        return ArrayHelper::toArray($products, [
            Product::className() => [
                'id' => 'Id',
                'title' => 'Title',
                'paid' => function (Product $product) {
                    $query = OrderItem::model()
                        ->with(['OrderLinks.Order'])
                        ->byProductId($product->Id)
                        ->byDeleted(false)
                        ->byPaid(true);
                    $criteria = $query->getDbCriteria();
                    $criteria->addCondition('not "Order"."Deleted" and "Order"."Paid"');
                    return $query->count();
                },
                'coupon' => function (Product $product) {
                    return OrderItem::model()->with(['OrderLinks'])->byProductId($product->Id)->byDeleted(false)->byPaid(true)->count(['condition' => '"OrderLinks"."Id" IS NULL']);
                },
                'total' => function (Product $product) {
                    $total = 0;
                    $orderItems = OrderItem::model()
                        ->with(['OrderLinks.Order'])
                        ->byProductId($product->Id)
                        ->byDeleted(false)
                        ->byPaid(true);
                    $orderItems->getDbCriteria()->addCondition('not "Order"."Deleted" and "Order"."Paid"');
                    $orderItems = $orderItems->findAll();

                    foreach ($orderItems as $orderItem) {
                        $order = $orderItem->getPaidOrder();
                        if (empty($order)) {
                            continue;
                        }
                        $collection = OrderItemCollection::createByOrder($order);
                        foreach ($collection as $item) {
                            if ($orderItem->Id === $item->getOrderItem()->Id) {
                                $total += $item->getPriceDiscount();
                            }
                        }
                    }
                    return $total;
                }
            ]
        ]);
    }
}

class PayStatistics
{
    public $totalJuridical = 0;
    public $countJuridicalOrders = 0;
    public $countJuridicalUsers = 0;

    public $totalPaidJuridical = 0;
    public $countPaidJuridicalOrders = 0;
    public $countPaidJuridicalUsers = 0;

    public $totalReceipt = 0;
    public $countReceiptOrders = 0;
    public $countReceiptUsers = 0;

    public $totalPaidReceipt = 0;
    public $countPaidReceiptOrders = 0;
    public $countPaidReceiptUsers = 0;

    public $totalPaySystem = 0;
    public $countPaySystemOrders = 0;
    public $countPaySystemUsers = 0;

    public $totalPaidPaySystem = 0;
    public $countPaidPaySystemOrders = 0;
    public $countPaidPaySystemUsers = 0;

    public $totalPaidPaypal = 0;
    public $countPaidPaypalOrders = 0;
    public $countPaidPaypalUsers = 0;

    public $totalPaypal = 0;
    public $countPaypalOrders = 0;
    public $countPaypalUsers = 0;

    public $countParticipants = 0;

    public $totalUsers = 0;
    public $totalPaidUsers = 0;
    public $totalPromoUsers = 0;

    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getTotalPaid()
    {
        return $this->totalPaidJuridical + $this->totalPaidPaySystem + $this->totalPaidReceipt + $this->totalPaidPaypal;
    }

    public function getTotalOrders()
    {
        return $this->countJuridicalOrders + $this->countReceiptOrders + $this->countPaySystemOrders + $this->countPaypalOrders;
    }

    public function getTotalPaidOrders()
    {
        return $this->countPaidJuridicalOrders + $this->countPaidReceiptOrders + $this->countPaidPaySystemOrders + $this->countPaidPaypalOrders;
    }
}