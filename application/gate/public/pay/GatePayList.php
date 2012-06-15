<?php
AutoLoader::Import('gate.source.*');

class GatePayList extends GateJsonCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $payerRocId = intval(Registry::GetRequestVar('PayerRocId', 0));

    $payer = User::GetByRocid($payerRocId);
    $event = Event::GetEventByIdName($this->EventName);
    if (empty($payer))
    {
      $this->SendJson(true, 201, 'Не найден пользователь с rocID:' .$payerRocId);
    }
    if (empty($event))
    {
      $this->SendJson(true, 202, 'Не найдено мероприятие с текстовым идентификатором ' . $this->EventName);
    }

    $orderItems = OrderItem::GetByEventId($payer->UserId, $event->EventId);
    $this->result['items'] = array();
    foreach ($orderItems as $item)
    {
      $obj = new stdClass();
      $obj->OrderItemId = $item->OrderItemId;
      $obj->OwnerRocId = $item->Owner->RocId;
      $obj->ProductId = $item->Product->ProductId;
      $obj->LastName = $item->Owner->LastName;
      $obj->FirstName = $item->Owner->FirstName;
      $obj->Price = $item->Price();
      $obj->Paid = $item->Paid;

      $couponActivated = $item->GetCouponActivated();
      if (!empty($couponActivated) && !empty($couponActivated->Coupon))
      {
        $obj->Discount = $couponActivated->Coupon->Discount;
      }
      else
      {
        $obj->Discount = 0;
      }

      $this->result['items'][] = $obj;
    }

    $orders = Order::GetOrdersWithJuridical($payer->UserId, $event->EventId);
    $this->result['orders'] = array();
    foreach ($orders as $order)
    {
      $orderObj = new stdClass();
      $orderObj->OrderId = $order->OrderId;
      $orderObj->CreationTime = $order->CreationTime;
      $orderObj->Items = array();
      foreach ($order->Items as $item)
      {
        $obj = new stdClass();
        $obj->OrderItemId = $item->OrderItemId;
        $obj->OwnerRocId = $item->Owner->RocId;
        $obj->ProductId = $item->Product->ProductId;
        $obj->LastName = $item->Owner->LastName;
        $obj->FirstName = $item->Owner->FirstName;
        $obj->Price = $item->Price();
        $obj->Paid = $item->Paid;

        $couponActivated = $item->GetCouponActivated();
        if (!empty($couponActivated) && !empty($couponActivated->Coupon))
        {
          $obj->Discount = $couponActivated->Coupon->Discount;
        }
        else
        {
          $obj->Discount = 0;
        }

        $orderObj->Items[] = $obj;
      }
      $this->result['orders'][] = $orderObj;
    }

    $this->SendJson();
  }
}
