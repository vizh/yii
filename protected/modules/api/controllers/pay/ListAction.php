<?php
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
    else if ($event == null)
    {
      throw new \api\components\Exception(301);
    }
    
    $result = new \stdClass();
    $orderItems = \pay\models\OrderItem::model()
      ->byPayerId($payer->Id)->byEventId($event->Id)->findAll();
    
    $result->Items = array();
    foreach ($orderItems as $orderItem)
    {
      $result->Items[] = $this->getAccount()->getDataBuilder()->createOrderItem($orderItem);
    }
    
    $orders = \pay\models\Order::model();
    
    //TODO: ДОДЕЛАЙ!!!!!!! ТО ЧТО СНИЗУ!!!!!!!!!!!!
  

    $orders = Order::GetOrdersWithJuridical($payer->UserId, $event->EventId);
    $result->Orders = array();
    foreach ($orders as $order)
    {
      $orderObj = new stdClass();
      $orderObj->OrderId = $order->OrderId;
      $orderObj->CreationTime = $order->CreationTime;
      $orderObj->Paid = $order->OrderJuridical->Paid == 1;
      $orderObj->Items = array();
      foreach ($order->Items as $item)
      {
        $orderObj->Items[] = $this->Account->DataBuilder()->CreateOrderItem($item);
      }
      $result->Orders[] = $orderObj;
    }

    $this->SendJson($result);
  }
}
