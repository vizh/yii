<?php
namespace api\controllers\pay;

class CouponAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $couponCode = $request->getParam('CouponCode');
    $payerRunetId = $request->getParam('PayerRunetId');
    if ($payerRunetId === null)
    {
      $payerRunetId = $request->getParam('PayerRocId');
    }
    $ownerRunetId = $request->getParam('OwnerRunetId');
    if ($ownerRunetId === null)
    {
      $ownerRunetId = $request->getParam('OwnerRocId');
    }
    $externalId = $request->getParam('ExternalId');

    /** @var $coupon \pay\models\Coupon */
    $coupon = \pay\models\Coupon::model()->byCode($couponCode)->byEventId($this->getEvent()->Id)->find();
    if ($coupon == null)
      throw new \api\components\Exception(406);

    $payer = null;
    $owner = null;
    if (!empty($externalId))
    {
      $externalUser = \api\models\ExternalUser::model()
          ->byExternalId($externalId)->byPartner($this->getAccount()->Role)->find();
      if ($externalUser === null)
        throw new \api\components\Exception(3003, [$externalId]);
      $payer = $owner = $externalUser;
    }
    else
    {
      $payer = \user\models\User::model()->byRunetId($payerRunetId)->find();
      $owner = \user\models\User::model()->byRunetId($ownerRunetId)->find();
      if ($owner == null)
        throw new \api\components\Exception(202, [$ownerRunetId]);
      if ($payer == null)
        throw new \api\components\Exception(202, [$payerRunetId]);
    }

    try
    {
      $coupon->activate($payer, $owner);
    }
    catch (\pay\components\Exception $e)
    {
      throw new \api\components\Exception(408, [$e->getCode(), $e->getMessage()], $e);
    }
    
    $result = new \stdClass();
    $result->Discount = $coupon->Discount;
    $this->getController()->setResult($result);
  }
}
