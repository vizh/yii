<?php

use mail\models\Template;
use pay\models\Coupon;
use pay\models\CouponLinkProduct;

class TestController extends \CController
{
    public function actionInfo()
    {

        //echo md5('Yii.'.get_class(Yii::app()->user).'.'.Yii::app()->getId());
        //exit;



        echo '<pre>';
        echo " \r\nrequest: \r\n";
        var_dump($_REQUEST);
        echo " \r\ncookies: \r\n";
        var_dump($_COOKIE);
        echo " \r\nsession: \r\n";
        var_dump($_SESSION);
        echo '</pre>';
    }

    public function actionCoupons()
    {
        echo 'closed';
        return;
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
