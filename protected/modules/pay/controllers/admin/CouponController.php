<?php
class CouponController extends \application\components\controllers\AdminMainController
{
    public function actions()
    {
        return [
            'multiple' => 'pay\controllers\admin\coupon\MultipleAction'
        ];
    }

} 