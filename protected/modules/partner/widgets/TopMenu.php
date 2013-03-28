<?php
namespace partner\widgets;

class TopMenu extends \CWidget
{

  public function run()
  {

    $menu = array();
    $menu[] = array(
      'Title' => 'Главная',
      'Url' => \Yii::app()->createUrl('/partner/main/index'),
      'Access' => $this->checkAccess('main', 'index'),
      'Active' => $this->isActive('main')
    );
    $menu[] = array(
      'Title' => 'Регистрации',
      'Url' => \Yii::app()->createUrl('/partner/ruvents/index'),
      'Access' => $this->checkAccess('ruvents', 'index'),
      'Active' => $this->isActive('ruvents')
    );
    $menu[] = array(
      'Title' => 'Счета',
      'Url' => \Yii::app()->createUrl('/partner/order/index'),
      'Access' => $this->checkAccess('order', 'index'),
      'Active' => $this->isActive('order')
    );
    $menu[] = array(
      'Title' => 'Участники',
      'Url' => \Yii::app()->createUrl('/partner/user/index'),
      'Access' => $this->checkAccess('user', 'index'),
      'Active' => $this->isActive('user')
    );
    $menu[] = array(
      'Title' => 'Промо-коды',
      'Url' => \Yii::app()->createUrl('/partner/coupon/index'),
      'Access' => $this->checkAccess('coupon', 'index'),
      'Active' => $this->isActive('coupon')
    );
    $menu[] = array(
      'Title' => 'Заказы',
      'Url' => \Yii::app()->createUrl('/partner/orderitem/index'),
      'Access' => $this->checkAccess('orderitem', 'index'),
      'Active' => $this->isActive('orderitem')
    );
    $menu[] = array(
      'Title' => 'Программа',
      'Url' => \Yii::app()->createUrl('/partner/program/index'),
      'Access' => $this->checkAccess('program', 'index'),
      'Active' => $this->isActive('program')
    );

    $this->render('topMenu', array('menu' => $menu));
  }

  protected function checkAccess($controller, $action)
  {
    return $this->getController()->getAccessFilter()->checkAccess('partner', $controller, $action);
  }

  protected function isActive($controller)
  {
    return $this->getController()->getId() == $controller;
  }
}