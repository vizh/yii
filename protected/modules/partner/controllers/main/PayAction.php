<?php
namespace partner\controllers\main;

class PayAction extends \partner\components\Action
{
  public function run()
  {
    ini_set("memory_limit", "512M");

    $this->getController()->setPageTitle('Статистика платежей');
    $this->getController()->initActiveBottomMenu('pay');

    $oldStatistics = $this->getOldStatistics();

    $statistics = new PayStatistics();

    $statistics->countJuridicalOrders = \pay\models\Order::model()
        ->byEventId($this->getEvent()->Id)->byBankTransfer(true)->count();


    $command = \Yii::app()->getDb()->createCommand()
        ->select('count("p"."Id") as "countPaid", sum("p"."Total") as "totalPaid"')
        ->from('PayOrder p')
        ->where('"p"."EventId" = :EventId AND "p"."Paid" AND "p"."Juridical"');
    $command->bindValue('EventId', $this->getEvent()->Id);
    $result = $command->queryRow();

    $statistics->countPaidJuridicalOrders = $result['countPaid'];
    $statistics->totalJuridical = $result['totalPaid'];

    $command = \Yii::app()->getDb()->createCommand()
        ->select('count("p"."Id") as "countPaid", sum("p"."Total") as "totalPaid"')
        ->from('PayOrder p')
        ->where('"p"."EventId" = :EventId AND "p"."Paid" AND NOT "p"."Juridical"');
    $command->bindValue('EventId', $this->getEvent()->Id);
    $result = $command->queryRow();

    $statistics->countPaidPhysicalOrders = $result['countPaid'];
    $statistics->totalPhysical = $result['totalPaid'];

    $this->getController()->render('pay', [
      'statistics' => $statistics,
      'oldStatistics' => $oldStatistics
    ]);
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
        $statistics->countPaidPhysicalOrders++;
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
            $statistics->totalPhysical += $item->getPriceDiscount();
          }
        }
      }
    }

    return $statistics;
  }

}


class PayStatistics
{
  public $countJuridicalOrders;
  public $countPaidJuridicalOrders;
  public $totalJuridical;
  public $countPaidPhysicalOrders;
  public $totalPhysical;

  public function __construct()
  {
    $this->countJuridicalOrders = 0;
    $this->countPaidJuridicalOrders = 0;
    $this->countPaidPhysicalOrders = 0;
    $this->totalJuridical = 0;
    $this->totalPhysical = 0;
  }
}