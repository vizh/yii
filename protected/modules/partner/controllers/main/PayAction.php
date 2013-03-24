<?php
namespace partner\controllers\main;

class PayAction extends \partner\components\Action
{
  public function run()
  {
    ini_set("memory_limit", "512M");

    $this->getController()->setPageTitle('Статистика платежей');
    $this->getController()->initActiveBottomMenu('pay');

    $event = \Yii::app()->partner->getEvent();

    $allOrdersCount = \pay\models\Order::model()
        ->byEventId($event->Id)->byJuridical(true)->count();

    /** @var $orders \pay\models\Order[] */
    $orders = \pay\models\Order::model()
        ->byEventId($event->Id)->byJuridical(true)->byPaid(true)
        ->with(array('ItemLinks.OrderItem' => array('together' => false)))
        ->findAll();
    $paidOrdersCount = sizeof($orders);
    $totalJuridical = 0;
    $paidItemIdList = array();
    foreach ($orders as $order)
    {
      foreach ($order->ItemLinks as $link)
      {
        if ($link->OrderItem->Paid)
        {
          $totalJuridical += $link->OrderItem->getPriceDiscount();
          $paidItemIdList[] = $link->OrderItem->Id;
        }
      }
    }

    $criteria = new \CDbCriteria();
    $criteria->addNotInCondition('"t"."Id"', $paidItemIdList);

    /** @var $orderItems \pay\models\OrderItem[] */
    $orderItems = \pay\models\OrderItem::model()
        ->byEventId($event->Id)->byPaid(true)
        ->with(array('Product'))
        ->findAll($criteria);
    $paidPhysicalItemsCount = sizeof($orderItems);
    $totalPhysical = 0;
    foreach ($orderItems as $item)
    {
      $totalPhysical += $item->getPriceDiscount();
    }

    $this->getController()->render('pay', array(
      'allOrdersCount' => $allOrdersCount,
      'paidOrdersCount' => $paidOrdersCount,
      'totalJuridical' => $totalJuridical,
      'paidPhysicalItemsCount' => $paidPhysicalItemsCount,
      'totalPhysical' => $totalPhysical,
    ));
  }

}
