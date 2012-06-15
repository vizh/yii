<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.event.*');

class PayCoupon extends ApiCommand
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
    $event = Event::GetById($this->Account->EventId);

    if (empty($coupon))
    {
      throw new ApiException(406);
    }
    if (empty($owner))
    {
      throw new ApiException(202, array($ownerRocId));
    }
    if (empty($payer))
    {
      throw new ApiException(202, array($payerRocId));
    }
    if (empty($event))
    {
      throw new ApiException(301);
    }
    if ($coupon->EventId != $event->EventId)
    {
      throw new ApiException(407);
    }

    try
    {
      $coupon->Activate($payer, $owner);
    }
    catch (PayException $e)
    {
      throw new ApiException(408, array($e->getCode(), $e->getMessage()));
    }

    $result = new stdClass();
    $result->Discount = $coupon->Discount;

    $this->SendJson($result);
  }
}
