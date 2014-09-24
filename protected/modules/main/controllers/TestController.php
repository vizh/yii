<?php

use pay\models\Coupon;
use pay\models\CouponLinkProduct;

class TestController extends \CController
{
    public function actionCoupons()
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 't."ProductId" IS NOT NULL';
        $criteria->order = 't."Id"';
        $criteria->limit = 2000;

        $coupons = Coupon::model()->findAll($criteria);
        foreach ($coupons as $coupon) {
            $link = new CouponLinkProduct();
            $link->CouponId = $coupon->Id;
            $link->ProductId = $coupon->ProductId;
            $link->save();

            $coupon->ProductId = null;
            $coupon->save();
        }
        echo 'done, left: ' . Coupon::model()->count('t."ProductId" IS NOT NULL');
    }
}
