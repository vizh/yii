<?php
namespace partner\components\widgets;

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
      'Title' => 'Счета',
      'Url' => \Yii::app()->createUrl('/partner/order/index'),
      'Access' => $this->checkAccess('order', 'index'),
      'Active' => $this->isActive('order')
    );
    /*$menu[] = array('Title' => 'Участники', 'Url' => \Yii::app()->createUrl(''));
    $menu[] = array('Title' => 'Промо-коды', 'Url' => \Yii::app()->createUrl(''));
    $menu[] = array('Title' => 'Заказы', 'Url' => \Yii::app()->createUrl(''));*/

    $this->render('topMenu', array('menu' => $menu));
  }

  protected function checkAccess($controller, $action)
  {
    return $this->getController()->getAccessFilter()->checkAccess($controller, $action);
  }

  protected function isActive($controller)
  {
    return $this->getController()->getId() == $controller;
  }
}