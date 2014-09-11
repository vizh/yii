<?php
namespace api\controllers\ms;

class PayInfoAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $externalId = $request->getParam('ExternalId');

    $externalUser = \api\models\ExternalUser::model()
        ->byExternalId($externalId)->byAccountId($this->getAccount()->Id)->find();
    if ($externalUser === null)
      throw new \api\components\Exception(3003, [$externalId]);

    /** @var $activation \pay\models\CouponActivation */
    $activation = \pay\models\CouponActivation::model()
        ->byUserId($externalUser->UserId)
        ->byEventId($this->getEvent()->Id)
        ->byEmptyLinkOrderItem()->find();

    $product = \pay\models\Product::model()->byEventId($this->getEvent()->Id)->byPublic(true)->find();

    $this->setResult([
      'Discount' => $activation != null ? $activation->Coupon->Discount : 0,
      'Price' => $product != null ? $product->getPrice() : null
    ]);
  }
}