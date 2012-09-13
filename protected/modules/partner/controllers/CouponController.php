<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alaris
 * Date: 9/6/12
 * Time: 12:12 PM
 * To change this template use File | Settings | File Templates.
 */
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
    );
  }

  public function initBottomMenu($active)
  {
    $this->bottomMenu = array(
      'index' => array(
        'Title' => 'Промо-коды',
        'Url' => \Yii::app()->createUrl('/partner/coupon/index'),
        'Access' => $this->getAccessFilter()->checkAccess('coupon', 'index')
      ),
      'users' => array(
        'Title' => 'Активированные промо-коды',
        'Url' => \Yii::app()->createUrl('/partner/coupon/users'),
        'Access' => $this->getAccessFilter()->checkAccess('user', 'edit')
      ),
      'activation' => array(
        'Title' => 'Активация промо-кода',
        'Url' => \Yii::app()->createUrl('/partner/coupon/activation'),
        'Access' => $this->getAccessFilter()->checkAccess('user', 'edit')
      ),
    );

    foreach ($this->bottomMenu as $key => $value)
    {
      $this->bottomMenu[$key]['Active'] = ($key == $active);
    }
  }
}
