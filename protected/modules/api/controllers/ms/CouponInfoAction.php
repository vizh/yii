<?php
namespace api\controllers\ms;

class CouponInfoAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $couponCode = $request->getParam('CouponCode');

    /** @var $coupon \pay\models\Coupon */
    $coupon = \pay\models\Coupon::model()->byEventId($this->getEvent()->Id)->byCode($couponCode)->find();
    if ($coupon == null)
      throw new \api\components\Exception(3006);
    elseif ($coupon->EventId != $this->getEvent()->Id)
      throw new \api\components\Exception(3006);

    try
    {
      $coupon->check();
    }
    catch (\pay\components\Exception $e)
    {
      throw new \api\components\Exception(408, [$e->getCode(), $e->getMessage()], $e);
    }

    $this->setResult(['Discount' => $coupon->Discount]);
  }
}