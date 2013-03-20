<?php
namespace api\controllers\pay;

class ListAction extends \api\components\Action
{
  public function run()
  {
    $payerRunetId = \Yii::app()->request->getParam('PayerRunetId');
    $payer = \user\models\User::model()->byRunetId($payerRunetId)->find();
    if ($payer == null)
    {
      throw new \api\components\Exception(202, array($payerRunetId));
    }
    else if ($this->getAccount()->Event === null)
    {
      throw new \api\components\Exception(301);
    }
    
    $result = new \stdClass();

    $orderItems = \pay\models\OrderItem::getFreeItems($payer->Id, $this->getAccount()->EventId);
    $result->Items = array();
    foreach ($orderItems as $orderItem)
    {
      $result->Items[] = $this->getAccount()->getDataBuilder()->createOrderItem($orderItem);
    }

    /** @var $orders \pay\models\Order[] */
    $orders = \pay\models\Order::model()
        ->byPayerId($payer->Id)
        ->byEventId($this->getAccount()->EventId)
        ->byJuridical(true)
        ->byDeleted(true)->with(array('ItemLinks.OrderItem', 'ItemLinks.OrderItem.Product'))
        ->findAll();

    $result->Orders = array();
    foreach ($orders as $order)
    {
      $orderObj = new \stdClass();
      $orderObj->OrderId = $order->Id;
      $orderObj->CreationTime = $order->CreationTime;
      $orderObj->Paid = $order->Paid;
      $orderObj->Url = \Yii::app()->createAbsoluteUrl('/pay/juridical/order', array(
        'orderId' => $order->Id,
        'hash' => $order->getHash()
      ));
      $orderObj->Items = array();
      foreach ($order->ItemLinks as $link)
      {
        $orderObj->Items[] = $this->getAccount()->getDataBuilder()->createOrderItem($link->OrderItem);
      }
      $result->Orders[] = $orderObj;
    }

    $this->getController()->setResult($result);
  }
}
