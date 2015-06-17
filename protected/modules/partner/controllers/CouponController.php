<?php

class CouponController extends \partner\components\Controller
{
    const CouponOnPage = 20;

    public function actions()
    {
        return [
            'index' => '\partner\controllers\coupon\IndexAction',
            'users' => '\partner\controllers\coupon\UsersAction',
            'activation' => '\partner\controllers\coupon\ActivationAction',
            'give' => '\partner\controllers\coupon\GiveAction',
            'generate' => '\partner\controllers\coupon\GenerateAction',
            'statistics' => '\partner\controllers\coupon\StatisticsAction',
            'delete' => '\partner\controllers\coupon\DeleteAction'
        ];
    }
}
