<?php
namespace api\controllers\pay;

class ListAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $payerRunetId = $request->getParam('PayerRunetId', null);
    if ($payerRunetId === null)
    {
      $payerRunetId = $request->getParam('PayerRocId', null);
    }

    $payer = \user\models\User::model()->byRunetId($payerRunetId)->find();
    if ($payer == null)
    {
      throw new \api\components\Exception(202, array($payerRunetId));
    }
    
    $result = new \stdClass();

    $order = new \pay\models\Order();
    $order->getUnpaidItems($payer, $this->getEvent());
    $orderItems = \pay\models\OrderItem::getFreeItems($payer->Id, $this->getEvent()->Id);
    $result->Items = array();
    foreach ($orderItems as $orderItem)
    {
      $result->Items[] = $this->getAccount()->getDataBuilder()->createOrderItem($orderItem);
    }

    /** @var $orders \pay\models\Order[] */
    $orders = \pay\models\Order::model()
        ->byPayerId($payer->Id)
        ->byEventId($this->getEvent()->Id)
        ->byJuridical(true)
        ->byDeleted(false)->with(array('ItemLinks.OrderItem', 'ItemLinks.OrderItem.Product'))
        ->findAll();

    $result->Orders = array();
    foreach ($orders as $order)
    {
      $orderObj = new \stdClass();
      $orderObj->OrderId = $order->Id;
      $orderObj->CreationTime = $order->CreationTime;
      $orderObj->Paid = $order->Paid;
      $orderObj->Url = \Yii::app()->createAbsoluteUrl('/pay/order/index', array(
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
