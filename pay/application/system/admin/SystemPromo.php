<?php
AutoLoader::Import('library.rocid.pay.*');

class SystemPromo extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $this->createCoupon('travel50', 0.5, 1000);
    $this->createCoupon('travel100', 1, 50);

    $this->createCoupon('educore50', 0.5, 1000);
    $this->createCoupon('educore100', 1, 50);

    $this->createCoupon('elegion50', 0.5, 1000);
    $this->createCoupon('elegion100', 1, 50);
  }

  private function createCoupon($code, $discount, $multiple = false)
  {
    $coupon = new Coupon();
    $coupon->EventId = 258;
    $coupon->Code = $code;
    $coupon->Discount = $discount;
    if ($multiple !== false)
    {
      $coupon->Multiple = $multiple;
    }
    $coupon->save();
  }
}
