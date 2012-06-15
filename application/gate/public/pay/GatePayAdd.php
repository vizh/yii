<?php
AutoLoader::Import('gate.source.*');

class GatePayAdd extends GateJsonCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $productId = intval(Registry::GetRequestVar('ProductId', 0));
    $payerRocId = intval(Registry::GetRequestVar('PayerRocId', 0));
    $ownerRocId = intval(Registry::GetRequestVar('OwnerRocId', 0));

    $product = Product::GetById($productId);
    $payer = User::GetByRocid($payerRocId);
    $owner = User::GetByRocid($ownerRocId);
    $event = Event::GetEventByIdName($this->EventName);
    if (empty($product))
    {
      $this->SendJson(true, 201, 'Не найден товар с id:' .$productId);
    }
    if (empty($payer))
    {
      $this->SendJson(true, 202, 'Не найден пользователь с rocID:' .$payerRocId);
    }
    if (empty($owner))
    {
      $this->SendJson(true, 203, 'Не найден пользователь с rocID:' .$ownerRocId);
    }
    if (empty($event))
    {
      $this->SendJson(true, 204, 'Не найдено мероприятие с текстовым идентификатором ' . $this->EventName);
    }
    if ($product->EventId != $event->EventId)
    {
      $this->SendJson(true, 205, 'Идентификатор мероприятия и идентификатор товара не совпадают.');
    }
    if (! $product->ProductManager()->CheckProduct($owner))
    {
      $this->SendJson(true, 206, 'Данный товар не может быть приобретен этим пользователем. Возможно уже куплен этот или аналогичный товар.');
    }

    $orderItem = OrderItem::GetByAll($productId, $payer->UserId, $owner->UserId);
    if (! empty($orderItem) && $orderItem->Paid == 0)
    {
      $this->result['OrderItemId'] = $orderItem->OrderItemId;
      $this->result['ProductTitle'] = $product->Title;
      $this->result['ProductPrice'] = $product->GetPrice();
      $this->SendJson(true, 207, 'Вы уже заказали этот товар.');
    }

    $coupon = Coupon::GetByUser($owner->UserId, $product->EventId);

    $this->result['test'] = 'userid:' . $owner->UserId . '  productid:' . $product->ProductId;

    $orderItem = new OrderItem();
    $orderItem->ProductId = $product->ProductId;
    $orderItem->PayerId = $payer->UserId;
    $orderItem->OwnerId = $owner->UserId;
    $orderItem->save();

    $this->result['OrderItemId'] = $orderItem->OrderItemId;
    $this->result['ProductTitle'] = $product->Title;
    $this->result['ProductPrice'] = $product->GetPrice();

    $this->result['LastName'] = $owner->LastName;
    $this->result['FirstName'] = $owner->FirstName;
    $this->result['Discount'] = !empty($coupon) && $product->EnableCoupon == 1 ? $coupon->Discount : 0;

    $this->SendJson();
  }
}
