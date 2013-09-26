<?php
namespace pay\components\collection\coupons;

abstract class Base implements \pay\components\collection\ICoupon
{

  /**
   * @var \pay\models\CollectionCoupon
   */
  protected $coupon;

  /**
   * @param \pay\models\CollectionCoupon $coupon
   */
  public function __construct(\pay\models\CollectionCoupon $coupon)
  {
    $this->coupon = $coupon;
  }

  public function __get($name)
  {
    if (!$this->coupon->getIsNewRecord() && in_array($name, $this->getCouponAttributeNames()))
    {
      $attributes = $this->coupon->getCouponAttributes();
      return isset($attributes[$name]) ? $attributes[$name]->Value : null;
    }
    else
    {
      return null;
    }
  }

  /**
   * Возвращает список доступных аттрибутов
   * @return string[]
   */
  protected abstract function getCouponAttributeNames();

}