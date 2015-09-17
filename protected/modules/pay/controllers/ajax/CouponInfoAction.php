<?php
namespace pay\controllers\ajax;

use pay\models\CouponActivation;
use pay\models\Product;
use pay\models\ReferralDiscount;
use user\models\User;

class CouponInfoAction extends \pay\components\Action
{
    public function run($runetId, $eventIdName, $productId)
    {
        $user = User::model()->byRunetId($runetId)->find();
        $product = Product::model()->findByPk($productId);

        $discount = 0;
        if ($user !== null && $product !== null) {
            $activation = CouponActivation::model()
                ->byUserId($user->Id)->byEventId($this->getEvent()->Id)->byEmptyLinkOrderItem()->find();

            $discount = $activation != null ? $activation->getDiscount($product) : 0;

            if (empty($discount)) {
                $referralDiscount = ReferralDiscount::findDiscount($product, $user);
                if ($referralDiscount !== null) {
                    $discount = $referralDiscount->getDiscount($product);
                }
            }
        }
        echo json_encode(['Discount' => $discount]);
    }
}