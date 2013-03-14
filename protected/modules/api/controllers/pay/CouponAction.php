<?php
namespace api\controllers\pay;
class CouponAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $couponCode = $request->getParam('CouponCode');
    $payerRunetId = $request->getParam('PayerRunetId');
    $ownerRunetId = $request->getParam('OwnerRunetId');
    
    $coupon = \pay\models\Coupon::model()->byCode($couponCode)->find();
    $payer = \user\models\User::model()->byRunetId($payerRunetId)->find();
    $owner = \user\models\User::model()->byRunetId($ownerRunetId)->find();
    if ($coupon == null)
    {
      throw new \api\components\Exception(406);
    }
    else if ($owner == null)
    {
      throw new \api\components\Exception(202, array($ownerRunetId));
    }
    else if ($payer == null)
    {
      throw new \api\components\Exception(202, array($payerRunetId));
    }
    else if ($this->getAccount()->Event == null)
    {
      throw new \api\components\Exception(301);
    }
    else if ($coupon->EventId != $this->getAccount()->EventId)
    {
      throw new \api\components\Exception(407);
    }

    try
    {
      $coupon->activate($payer, $owner);
    }
    catch (\pay\components\Exception $e)
    {
      throw new \api\components\Exception(408, array($e->getCode(), $e->getMessage()));
    }
    
    $result = new \stdClass();
    $result->Discount = $coupon->Discount;
    $this->getController()->setResult($result);
  }
}
