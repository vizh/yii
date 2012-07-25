<?php
namespace partner\components\widgets;

class TopMenu extends \CWidget
{

  public function run()
  {

    $menu = array();
    echo '123';
    echo $this->getController()->getAccessFilter()->checkAccess('main', 'index');
    echo '456';
    $menu[] = array(
      'Title' => 'Главная',
      'Url' => \Yii::app()->createUrl('/partner/main/index'),
      'Access' => $this->getController()->getAccessFilter()->checkAccess('main', 'index'),
      'Active' => $this->getController()->getId() == 'main'
    );
    echo '456';
    /*$menu[] = array('Title' => 'Счета', 'Url' => \Yii::app()->createUrl(''));
    $menu[] = array('Title' => 'Участники', 'Url' => \Yii::app()->createUrl(''));
    $menu[] = array('Title' => 'Промо-коды', 'Url' => \Yii::app()->createUrl(''));
    $menu[] = array('Title' => 'Заказы', 'Url' => \Yii::app()->createUrl(''));*/

    $this->render('topMenu', array('menu' => $menu));
  }
}