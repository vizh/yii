<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.event.*');

class PayDelete extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $orderItemId = intval(Registry::GetRequestVar('OrderItemId', 0));
    $payerRocId = intval(Registry::GetRequestVar('PayerRocId', 0));

    $orderItem = OrderItem::GetById($orderItemId);
    $payer = User::GetByRocid($payerRocId);
    $event = Event::GetById($this->Account->EventId);

    if (empty($orderItem))
    {
      throw new ApiException(409);
    }
    if (empty($payer))
    {
      throw new ApiException(202, array($payerRocId));
    }
    if ($orderItem->PayerId != $payer->UserId)
    {
      throw new ApiException(410);
    }
    if (empty($event))
    {
      throw new ApiException(301);
    }
    if ($orderItem->Product->EventId != $event->EventId)
    {
      throw new ApiException(402);
    }
    if ($orderItem->Paid == 1)
    {
      throw new ApiException(411);
    }

    /** @var $orders Order[] */
    $orders = $orderItem->Orders(array('with' => array('OrderJuridical')));
    foreach ($orders as $order)
    {
      if (!empty($order->OrderJuridical) && $order->OrderJuridical->Deleted == 0)
      {
        throw new ApiException(412);
      }
    }

    $orderItem->Deleted = 1;
    $orderItem->save();

    $this->SendJson(array('Success' => true));
  }
}
