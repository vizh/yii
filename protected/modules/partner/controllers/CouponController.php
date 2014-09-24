<?php

class CouponController extends \partner\components\Controller
{
  const CouponOnPage = 20;

  public function actions()
  {
    return array(
      'index' => '\partner\controllers\coupon\IndexAction',
      'users' => '\partner\controllers\coupon\UsersAction',
      'activation' => '\partner\controllers\coupon\ActivationAction',
      'give' => '\partner\controllers\coupon\GiveAction',
      'generate' => '\partner\controllers\coupon\GenerateAction',
        'statistics' => '\partner\controllers\coupon\StatisticsAction'
    );
  }

  public function initBottomMenu()
  {
    $this->bottomMenu = array(
      'index' => array(
        'Title' => 'Промо-коды',
        'Url' => \Yii::app()->createUrl('/partner/coupon/index'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'coupon', 'index')
      ),
      /*'users' => array(
        'Title' => 'Активированные промо-коды',
        'Url' => \Yii::app()->createUrl('/partner/coupon/users'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'coupon', 'users')
      ),
      'activation' => array(
        'Title' => 'Активация промо-кода',
        'Url' => \Yii::app()->createUrl('/partner/coupon/activation'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'coupon', 'activation')
      ),*/
      'generate' => array(
        'Title' => 'Генерация промо-кодов',
        'Url' => \Yii::app()->createUrl('/partner/coupon/generate'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'coupon', 'generate')
      ),
    );
  }
}
