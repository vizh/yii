<?php
namespace partner\controllers\main;

use application\components\helpers\ArrayHelper;
use pay\components\OrderItemCollection;
use pay\models\OrderItem;
use pay\models\Product;

class PayAction extends \partner\components\Action
{
    /** @var PayStatistics  */
    public $statistics;

    public function run()
    {
        ini_set("memory_limit", "512M");
        $oldStatistics = $this->getOldStatistics();

        $this->statistics = new PayStatistics();

        $this->statistics->countParticipants = \user\models\User::model()->byEventId($this->getEvent()->Id)->count();

        $this->fillJuridical();
        $this->fillReceipt();
        $this->fillPaySystem();
        $this->fillTotalUsers();

        $productStatistics = $this->getProductStatistics();


        $this->getController()->render('pay', [
            'statistics' => $this->statistics,
            'oldStatistics' => $oldStatistics,
            'productStatistics' => $productStatistics,
            'event' => $this->getEvent()
        ]);
    }

    private function fillJuridical()
    {
        $orders = \pay\models\Order::model()->byDeleted(false)
            ->byEventId($this->getEvent()->Id)->byJuridical(true)->findAll();
        $this->statistics->totalJuridical = array_reduce($orders, function($carry, $order){ return $carry + $order->price; }, 0);
        $this->statistics->countJuridicalOrders = count($orders);

        $command = \Yii::app()->getDb()->createCommand()
            ->select('count("p"."Id") as "countPaid", sum("p"."Total") as "totalPaid"')
            ->from('PayOrder p')
            ->where('"p"."EventId" = :EventId and not "p"."Deleted" AND "p"."Paid" AND "p"."Type" = :Type');
        $command->bindValue('EventId', $this->getEvent()->Id);
        $command->bindValue('Type', \pay\models\OrderType::Juridical);
        $result = $command->queryRow();

        $this->statistics->countPaidJuridicalOrders = $result['countPaid'];
        $this->statistics->totalPaidJuridical = $result['totalPaid'];

        $command = \Yii::app()->getDb()->createCommand()
            ->select('count(DISTINCT "oi"."OwnerId") as "countUsers"')
            ->from('PayOrder o')
            ->leftJoin('PayOrderLinkOrderItem oloi', '"oloi"."OrderId" = "o"."Id"')
            ->leftJoin('PayOrderItem oi', '"oloi"."OrderItemId" = "oi"."Id"')
            ->where('"o"."EventId" = :EventId AND "o"."Paid" and NOT "o"."Deleted" AND "o"."Type" = :Type');
        $command->bindValue('EventId', $this->getEvent()->Id);
        $command->bindValue('Type', \pay\models\OrderType::Juridical);
        $result = $command->queryRow();

        $this->statistics->countJuridicalUsers = $result['countUsers'];

        $command = \Yii::app()->getDb()->createCommand()
            ->select('count(DISTINCT "oi"."OwnerId") as "countUsers"')
            ->from('PayOrder o')
            ->leftJoin('PayOrderLinkOrderItem oloi', '"oloi"."OrderId" = "o"."Id"')
            ->leftJoin('PayOrderItem oi', '"oloi"."OrderItemId" = "oi"."Id"')
            ->where('"o"."EventId" = :EventId and not "o"."Deleted" AND "o"."Paid" AND "o"."Type" = :Type');
        $command->bindValue('EventId', $this->getEvent()->Id);
        $command->bindValue('Type', \pay\models\OrderType::Juridical);
        $result = $command->queryRow();

        $this->statistics->countPaidJuridicalUsers = $result['countUsers'];
    }

    private function fillReceipt()
    {
        $orders = \pay\models\Order::model()->byDeleted(false)
            ->byEventId($this->getEvent()->Id)->byReceipt(true)->findAll();
        $this->statistics->totalReceipt = array_reduce($orders, function($carry, $order){ return $carry + $order->price; }, 0);
        $this->statistics->countReceipts = count($orders);

        $command = \Yii::app()->getDb()->createCommand()
            ->select('count("p"."Id") as "countPaid", sum("p"."Total") as "totalPaid"')
            ->from('PayOrder p')
            ->where('"p"."EventId" = :EventId and not "p"."Deleted" AND "p"."Paid" AND "p"."Type" = :Type');
        $command->bindValue('EventId', $this->getEvent()->Id);
        $command->bindValue('Type', \pay\models\OrderType::Receipt);
        $result = $command->queryRow();

        $this->statistics->countPaidReceipts = $result['countPaid'];
        $this->statistics->totalPaidReceipt = $result['totalPaid'];

        $command = \Yii::app()->getDb()->createCommand()
            ->select('count(DISTINCT "oi"."OwnerId") as "countUsers"')
            ->from('PayOrder o')
            ->leftJoin('PayOrderLinkOrderItem oloi', '"oloi"."OrderId" = "o"."Id"')
            ->leftJoin('PayOrderItem oi', '"oloi"."OrderItemId" = "oi"."Id"')
            ->where('"o"."EventId" = :EventId AND "o"."Paid" and NOT "o"."Deleted" AND "o"."Type" = :Type');
        $command->bindValue('EventId', $this->getEvent()->Id);
        $command->bindValue('Type', \pay\models\OrderType::Receipt);
        $result = $command->queryRow();

        $this->statistics->countReceiptUsers = $result['countUsers'];

        $command = \Yii::app()->getDb()->createCommand()
            ->select('count(DISTINCT "oi"."OwnerId") as "countUsers"')
            ->from('PayOrder o')
            ->leftJoin('PayOrderLinkOrderItem oloi', '"oloi"."OrderId" = "o"."Id"')
            ->leftJoin('PayOrderItem oi', '"oloi"."OrderItemId" = "oi"."Id"')
            ->where('"o"."EventId" = :EventId and not "o"."Deleted" AND "o"."Paid"  AND "o"."Type" = :Type');
        $command->bindValue('EventId', $this->getEvent()->Id);
        $command->bindValue('Type', \pay\models\OrderType::Receipt);
        $result = $command->queryRow();

        $this->statistics->countPaidReceiptUsers = $result['countUsers'];
    }

    private function fillPaySystem()
    {
        $this->statistics->countPaySystemOrders = \pay\models\Order::model()->byDeleted(false)->byPaid(true)
            ->byEventId($this->getEvent()->Id)->byBankTransfer(false)->count();

        $command = \Yii::app()->getDb()->createCommand()
            ->select('count("p"."Id") as "countPaid", sum("p"."Total") as "totalPaid"')
            ->from('PayOrder p')
            ->where('"p"."EventId" = :EventId and not "p"."Deleted" AND "p"."Paid" AND "p"."Type" != :Type1 AND "p"."Type" != :Type2');
        $command->bindValue('EventId', $this->getEvent()->Id);
        $command->bindValue('Type1', \pay\models\OrderType::Juridical);
        $command->bindValue('Type2', \pay\models\OrderType::Receipt);
        $result = $command->queryRow();

        $this->statistics->countPaidPaySystemOrders = $result['countPaid'];
        $this->statistics->totalPaidPaySystem = $result['totalPaid'];

        $command = \Yii::app()->getDb()->createCommand()
            ->select('count(DISTINCT "oi"."OwnerId") as "countUsers"')
            ->from('PayOrder o')
            ->leftJoin('PayOrderLinkOrderItem oloi', '"oloi"."OrderId" = "o"."Id"')
            ->leftJoin('PayOrderItem oi', '"oloi"."OrderItemId" = "oi"."Id"')
            ->where('"o"."EventId" = :EventId AND "o"."Paid" and NOT "o"."Deleted" AND "o"."Type" != :Type1 AND "o"."Type" != :Type2');
        $command->bindValue('EventId', $this->getEvent()->Id);
        $command->bindValue('Type1', \pay\models\OrderType::Juridical);
        $command->bindValue('Type2', \pay\models\OrderType::Receipt);
        $result = $command->queryRow();

        $this->statistics->countPaySystemUsers = $result['countUsers'];

        $command = \Yii::app()->getDb()->createCommand()
            ->select('count(DISTINCT "oi"."OwnerId") as "countUsers"')
            ->from('PayOrder o')
            ->leftJoin('PayOrderLinkOrderItem oloi', '"oloi"."OrderId" = "o"."Id"')
            ->leftJoin('PayOrderItem oi', '"oloi"."OrderItemId" = "oi"."Id"')
            ->where('"o"."EventId" = :EventId and not "o"."Deleted" AND "o"."Paid" AND "o"."Type" != :Type1 AND "o"."Type" != :Type2');
        $command->bindValue('EventId', $this->getEvent()->Id);
        $command->bindValue('Type1', \pay\models\OrderType::Juridical);
        $command->bindValue('Type2', \pay\models\OrderType::Receipt);
        $result = $command->queryRow();

        $this->statistics->countPaidPaySystemUsers = $result['countUsers'];
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
        return ArrayHelper::toArray($products, [Product::className() => [
            'id' => 'Id',
            'title' => 'Title',
            'paid' => function (Product $product) {
                return OrderItem::model()->with(['OrderLinks.Order'])->byProductId($product->Id)->byDeleted(false)->byPaid(true)->count(['condition' => '"Order"."Paid"']);
            },
            'coupon' => function (Product $product) {
                return OrderItem::model()->with(['OrderLinks'])->byProductId($product->Id)->byDeleted(false)->byPaid(true)->count(['condition' => '"OrderLinks"."Id" IS NULL']);
            },
            'total' => function (Product $product) {
                $total = 0;
                $orderItems = OrderItem::model()->with(['OrderLinks.Order'])->byProductId($product->Id)->byDeleted(false)->byPaid(true)->findAll();
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
        ]]);
    }


    private function getOldStatistics()
    {
        $statistics = new PayStatistics();
        $statistics->countJuridicalOrders = \pay\models\Order::model()
            ->byEventId($this->getEvent()->Id)->byBankTransfer(true)->count();

        if (\Yii::app()->partner->getAccount()->Role != 'AdminExtended' || $statistics->countJuridicalOrders > 100)
        {
            return null;
        }

        /** @var $orders \pay\models\Order[] */
        $orders = \pay\models\Order::model()
            ->byEventId($this->getEvent()->Id)->byPaid(true)
            ->with(array('ItemLinks.OrderItem' => array('together' => false)))
            ->findAll();

        foreach ($orders as $order)
        {
            $collection = \pay\components\OrderItemCollection::createByOrder($order);
            if ($order->Juridical)
            {
                $statistics->countPaidJuridicalOrders++;
            }
            else
            {
                $statistics->countPaySystemOrders++;
            }

            foreach ($collection as $item)
            {
                if ($item->getOrderItem()->Paid) {
                    if ($order->Juridical) {
                        $statistics->totalPaidJuridical += $item->getPriceDiscount();
                    } else {
                        $statistics->totalPaySystem += $item->getPriceDiscount();
                    }
                }
            }
        }

        return $statistics;
    }

}


class PayStatistics
{
    public $totalJuridical = 0;
    public $totalPaidJuridical = 0;

    public $totalReceipt = 0;
    public $totalPaidReceipt = 0;

    public $totalPaySystem = 0;
    public $totalPaidPaySystem = 0;


    public $countParticipants = 0;

    public $countJuridicalOrders = 0;
    public $countPaidJuridicalOrders = 0;

    public $countJuridicalUsers = 0;
    public $countPaidJuridicalUsers = 0;

    public $countReceipts = 0;
    public $countPaidReceipts = 0;

    public $countReceiptUsers = 0;
    public $countPaidReceiptUsers = 0;

    public $countPaySystemOrders = 0;
    public $countPaidPaySystemOrders = 0;

    public $countPaySystemUsers = 0;
    public $countPaidPaySystemUsers = 0;

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
        return $this->totalPaidJuridical + $this->totalPaidPaySystem + $this->totalPaidReceipt;
    }

    public function getTotalOrders()
    {
        return $this->countJuridicalOrders + $this->countReceipts + $this->countPaySystemOrders;
    }

    public function getTotalPaidOrders()
    {
        return $this->countPaidJuridicalOrders + $this->countPaidReceipts + $this->countPaidPaySystemOrders;
    }
}