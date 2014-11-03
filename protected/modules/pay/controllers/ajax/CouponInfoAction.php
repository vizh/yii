<?php
namespace pay\controllers\ajax;

class CouponInfoAction extends \pay\components\Action
{
  public function run($runetId, $eventIdName, $productId)
  {
    $user = \user\models\User::model()->byRunetId($runetId)->find();
    $product = \pay\models\Product::model()->findByPk($productId);
    $discount = 0;
    if ($user != null && $product != null)
    {
      /** @var $activation \pay\models\CouponActivation */
      $activation = \pay\models\CouponActivation::model()
          ->byUserId($user->Id)
          ->byEventId($this->getEvent()->Id)
          ->byEmptyLinkOrderItem()->find();

      $discount = $activation != null ? $activation->getDiscount($product) : 0;

        //todo: реализовать вычисление скидки для программы лояльности
//      $loyaltyDiscount = $user->getLoyaltyDiscount($product);
//      if ($loyaltyDiscount !== null && $loyaltyDiscount->Discount > $discount)
//      {
//        $discount = $loyaltyDiscount->Discount;
//      }
    }
    echo json_encode(['Discount' => $discount]);
  }
}