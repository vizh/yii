<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.event.*');

class PayList extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $payerRocId = intval(Registry::GetRequestVar('PayerRocId', 0));

    $payer = User::GetByRocid($payerRocId);
    $event = Event::GetById($this->Account->EventId);
    if (empty($payer))
    {
      throw new ApiException(202, array($payerRocId));
    }
    if (empty($event))
    {
      throw new ApiException(301);
    }

    $result = new stdClass();
    $orderItems = OrderItem::GetByEventId($payer->UserId, $event->EventId);
    $result->Items = array();
    foreach ($orderItems as $item)
    {
      $result->Items[] = $this->Account->DataBuilder()->CreateOrderItem($item);
    }

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
