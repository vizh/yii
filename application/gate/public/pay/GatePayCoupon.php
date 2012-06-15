<?php
AutoLoader::Import('gate.source.*');

 
class GatePayCoupon extends GateJsonCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $couponCode = Registry::GetRequestVar('CouponCode', null);
    $payerRocId = intval(Registry::GetRequestVar('PayerRocId', 0));
    $ownerRocId = intval(Registry::GetRequestVar('OwnerRocId', 0));

    $coupon = Coupon::GetByCode($couponCode);
    $payer = User::GetByRocid($payerRocId);
    $owner = User::GetByRocid($ownerRocId);
    $event = Event::GetEventByIdName($this->EventName);

    if (empty($coupon))
    {
      $this->SendJson(true, 202, 'Указанный промо код введен не корректно или не существует.');
    }
    if (empty($owner))
    {
      $this->SendJson(true, 203, 'Не найден пользователь с rocID:' .$ownerRocId);
    }
    if (empty($payer))
    {
      $this->SendJson(true, 203, 'Не найден пользователь с rocID:' .$payerRocId);
    }
    if (empty($event))
    {
      $this->SendJson(true, 204, 'Не найдено мероприятие с текстовым идентификатором ' . $this->EventName);
    }
    if ($coupon->EventId != $event->EventId)
    {
      $this->SendJson(true, 205, 'Идентификатор мероприятия и идентификатор промо кода не совпадают.');
    }

    try
    {
      $coupon->Activate($payer, $owner);
    }
    catch (PayException $e)
    {
      $this->SendJson(true, $e->getCode(), $e->getMessage());
    }

    $this->result['Discount'] = $coupon->Discount;
    $this->SendJson();
  }
}
