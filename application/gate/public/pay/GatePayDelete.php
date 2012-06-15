<?php
AutoLoader::Import('gate.source.*');

class GatePayDelete extends GateJsonCommand
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
    $event = Event::GetEventByIdName($this->EventName);

    if (empty($orderItem))
    {
      $this->SendJson(true, 201, 'Не найден элемент заказа с таким идентификатором.');
    }
    if (empty($payer))
    {
      $this->SendJson(true, 202, 'Не найден пользователь с rocID:' .$payerRocId);
    }
    if ($orderItem->PayerId != $payer->UserId)
    {
      $this->SendJson(true, 203, 'Ошибка при удалении. Попытка удалить заказ, принадлежащий другому пользователю');
    }
    if (empty($event))
    {
      $this->SendJson(true, 204, 'Не найдено мероприятие с текстовым идентификатором ' . $this->EventName);
    }
    if ($orderItem->Product->EventId != $event->EventId)
    {
      $this->SendJson(true, 205, 'Идентификатор мероприятия и идентификатор товара не совпадают.');
    }
    if ($orderItem->Paid == 1)
    {
      $this->SendJson(true, 206, 'Данный элемент заказ уже оплачен. Вы не можете удалить уже оплаченые товары.');
    }

    /** @var $orders Order[] */
    $orders = $orderItem->Orders(array('with' => array('OrderJuridical')));
    foreach ($orders as $order)
    {
      if (!empty($order->OrderJuridical) && $order->OrderJuridical->Deleted == 0)
      {
        $this->SendJson(true, 207, 'Данный элемент заказа включе в выписанный счет, и не может быть удален.');
      }
    }

    $orderItem->Deleted = 1;
    $orderItem->save();
    $this->SendJson();
  }
}
