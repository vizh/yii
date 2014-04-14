<?php
namespace partner\controllers\main;

class PayAction extends \partner\components\Action
{
  /** @var PayStatistics  */
  public $statistics;

  public function run()
  {
    ini_set("memory_limit", "512M");

    $this->getController()->setPageTitle('Статистика платежей');
    $this->getController()->initActiveBottomMenu('pay');

    $oldStatistics = $this->getOldStatistics();

    $this->statistics = new PayStatistics();

    $this->statistics->countParticipants = \user\models\User::model()->byEventId($this->getEvent()->Id)->count();

    $this->fillJuridical();
    $this->fillReceipt();
    $this->fillPaySystem();
    $this->fillTotalUsers();


    $this->getController()->render('pay', [
      'statistics' => $this->statistics,
      'oldStatistics' => $oldStatistics
    ]);
  }

  private function fillJuridical()
  {
    $this->statistics->countJuridicalOrders = \pay\models\Order::model()->byDeleted(false)->byPaid(true, false)
        ->byEventId($this->getEvent()->Id)->byJuridical(true)->count();

    $command = \Yii::app()->getDb()->createCommand()
        ->select('count("p"."Id") as "countPaid", sum("p"."Total") as "totalPaid"')
        ->from('PayOrder p')
        ->where('"p"."EventId" = :EventId AND "p"."Paid" AND "p"."Type" = :Type');
    $command->bindValue('EventId', $this->getEvent()->Id);
    $command->bindValue('Type', \pay\models\OrderType::Juridical);
    $result = $command->queryRow();

    $this->statistics->countPaidJuridicalOrders = $result['countPaid'];
    $this->statistics->totalJuridical = $result['totalPaid'];

    $command = \Yii::app()->getDb()->createCommand()
        ->select('count(DISTINCT "oi"."OwnerId") as "countUsers"')
        ->from('PayOrder o')
        ->leftJoin('PayOrderLinkOrderItem oloi', '"oloi"."OrderId" = "o"."Id"')
        ->leftJoin('PayOrderItem oi', '"oloi"."OrderItemId" = "oi"."Id"')
        ->where('"o"."EventId" = :EventId AND ("o"."Paid" OR NOT "o"."Deleted") AND "o"."Type" = :Type');
    $command->bindValue('EventId', $this->getEvent()->Id);
    $command->bindValue('Type', \pay\models\OrderType::Juridical);
    $result = $command->queryRow();

    $this->statistics->countJuridicalUsers = $result['countUsers'];

    $command = \Yii::app()->getDb()->createCommand()
        ->select('count(DISTINCT "oi"."OwnerId") as "countUsers"')
        ->from('PayOrder o')
        ->leftJoin('PayOrderLinkOrderItem oloi', '"oloi"."OrderId" = "o"."Id"')
        ->leftJoin('PayOrderItem oi', '"oloi"."OrderItemId" = "oi"."Id"')
        ->where('"o"."EventId" = :EventId AND "o"."Paid" AND "o"."Type" = :Type');
    $command->bindValue('EventId', $this->getEvent()->Id);
    $command->bindValue('Type', \pay\models\OrderType::Juridical);
    $result = $command->queryRow();

    $this->statistics->countPaidJuridicalUsers = $result['countUsers'];
  }

  private function fillReceipt()
  {
    $this->statistics->countReceipts = \pay\models\Order::model()->byDeleted(false)->byPaid(true, false)
        ->byEventId($this->getEvent()->Id)->byReceipt(true)->count();

    $command = \Yii::app()->getDb()->createCommand()
        ->select('count("p"."Id") as "countPaid", sum("p"."Total") as "totalPaid"')
        ->from('PayOrder p')
        ->where('"p"."EventId" = :EventId AND "p"."Paid" AND "p"."Type" = :Type');
    $command->bindValue('EventId', $this->getEvent()->Id);
    $command->bindValue('Type', \pay\models\OrderType::Receipt);
    $result = $command->queryRow();

    $this->statistics->countPaidReceipts = $result['countPaid'];
    $this->statistics->totalReceipt = $result['totalPaid'];

    $command = \Yii::app()->getDb()->createCommand()
        ->select('count(DISTINCT "oi"."OwnerId") as "countUsers"')
        ->from('PayOrder o')
        ->leftJoin('PayOrderLinkOrderItem oloi', '"oloi"."OrderId" = "o"."Id"')
        ->leftJoin('PayOrderItem oi', '"oloi"."OrderItemId" = "oi"."Id"')
        ->where('"o"."EventId" = :EventId AND ("o"."Paid" OR NOT "o"."Deleted") AND "o"."Type" = :Type');
    $command->bindValue('EventId', $this->getEvent()->Id);
    $command->bindValue('Type', \pay\models\OrderType::Receipt);
    $result = $command->queryRow();

    $this->statistics->countReceiptUsers = $result['countUsers'];

    $command = \Yii::app()->getDb()->createCommand()
        ->select('count(DISTINCT "oi"."OwnerId") as "countUsers"')
        ->from('PayOrder o')
        ->leftJoin('PayOrderLinkOrderItem oloi', '"oloi"."OrderId" = "o"."Id"')
        ->leftJoin('PayOrderItem oi', '"oloi"."OrderItemId" = "oi"."Id"')
        ->where('"o"."EventId" = :EventId AND "o"."Paid"  AND "o"."Type" = :Type');
    $command->bindValue('EventId', $this->getEvent()->Id);
    $command->bindValue('Type', \pay\models\OrderType::Receipt);
    $result = $command->queryRow();

    $this->statistics->countPaidReceiptUsers = $result['countUsers'];
  }

  private function fillPaySystem()
  {
    $this->statistics->countPaySystemOrders = \pay\models\Order::model()->byDeleted(false)->byPaid(true, false)
        ->byEventId($this->getEvent()->Id)->byBankTransfer(false)->count();

    $command = \Yii::app()->getDb()->createCommand()
        ->select('count("p"."Id") as "countPaid", sum("p"."Total") as "totalPaid"')
        ->from('PayOrder p')
        ->where('"p"."EventId" = :EventId AND "p"."Paid" AND "p"."Type" != :Type1 AND "p"."Type" != :Type2');
    $command->bindValue('EventId', $this->getEvent()->Id);
    $command->bindValue('Type1', \pay\models\OrderType::Juridical);
    $command->bindValue('Type2', \pay\models\OrderType::Receipt);
    $result = $command->queryRow();

    $this->statistics->countPaidPaySystemOrders = $result['countPaid'];
    $this->statistics->totalPaySystem = $result['totalPaid'];

    $command = \Yii::app()->getDb()->createCommand()
        ->select('count(DISTINCT "oi"."OwnerId") as "countUsers"')
        ->from('PayOrder o')
        ->leftJoin('PayOrderLinkOrderItem oloi', '"oloi"."OrderId" = "o"."Id"')
        ->leftJoin('PayOrderItem oi', '"oloi"."OrderItemId" = "oi"."Id"')
        ->where('"o"."EventId" = :EventId AND ("o"."Paid" OR NOT "o"."Deleted") AND "o"."Type" != :Type1 AND "o"."Type" != :Type2');
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
        ->where('"o"."EventId" = :EventId AND "o"."Paid" AND "o"."Type" != :Type1 AND "o"."Type" != :Type2');
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
        ->where('"o"."EventId" = :EventId AND ("o"."Paid" OR NOT "o"."Deleted")');
    $command->bindValue('EventId', $this->getEvent()->Id);
    $result = $command->queryRow();

    $this->statistics->totalUsers = $result['countUsers'];

    $command = \Yii::app()->getDb()->createCommand()
        ->select('count(DISTINCT "oi"."OwnerId") as "countUsers"')
        ->from('PayOrder o')
        ->leftJoin('PayOrderLinkOrderItem oloi', '"oloi"."OrderId" = "o"."Id"')
        ->leftJoin('PayOrderItem oi', '"oloi"."OrderItemId" = "oi"."Id"')
        ->where('"o"."EventId" = :EventId AND "o"."Paid"');
    $command->bindValue('EventId', $this->getEvent()->Id);
    $result = $command->queryRow();

    $this->statistics->totalPaidUsers = $result['countUsers'];

    $command = \Yii::app()->getDb()->createCommand()
        ->select('count(DISTINCT "ca"."UserId") as "countUsers"')
        ->from('PayCouponActivation ca')
        ->leftJoin('PayCoupon c', '"ca"."CouponId" = "c"."Id"')
        ->where('"c"."EventId" = :EventId AND "c"."Discount" = 1');
    $command->bindValue('EventId', $this->getEvent()->Id);
    $result = $command->queryRow();

    $this->statistics->totalPromoUsers = $result['countUsers'];
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
        if ($item->getOrderItem()->Paid)
        {
          if ($order->Juridical)
          {
            $statistics->totalJuridical += $item->getPriceDiscount();
          }
          else
          {
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
  public $countParticipants = 0;

  public $countJuridicalOrders = 0;
  public $countPaidJuridicalOrders = 0;
  public $countJuridicalUsers = 0;
  public $countPaidJuridicalUsers = 0;
  public $totalJuridical = 0;

  public $countReceipts = 0;
  public $countPaidReceipts = 0;
  public $countReceiptUsers = 0;
  public $countPaidReceiptUsers = 0;
  public $totalReceipt = 0;

  public $countPaySystemOrders = 0;
  public $countPaidPaySystemOrders = 0;
  public $countPaySystemUsers = 0;
  public $countPaidPaySystemUsers = 0;
  public $totalPaySystem = 0;

  public $totalUsers = 0;
  public $totalPaidUsers = 0;
  public $totalPromoUsers = 0;


  public function __construct()
  {
  }

  /**
   * @return int
   */
  public function getTotal()
  {
    return $this->totalJuridical + $this->totalPaySystem + $this->totalReceipt;
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