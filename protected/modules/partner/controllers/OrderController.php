<?php

class OrderController extends \partner\components\Controller
{
  const OrdersOnPage = 2;

  public function actions()
  {
    return array(
      'index' => '\partner\controllers\order\IndexAction',
      'create' => '\partner\controllers\order\CreateAction',
      'view' => '\partner\controllers\order\ViewAction',
      'search' => '\partner\controllers\order\SearchAction',
    );
  }

  public function initBottomMenu($active)
  {
    $this->bottomMenu = array(
      'inactive' => array(
        'Title' => 'Неактивированные счета',
        'Url' => \Yii::app()->createUrl('/partner/order/index'),
        'Access' => $this->getAccessFilter()->checkAccess('order', 'index')
      ),
      'active' => array(
        'Title' => 'Активированные счета',
        'Url' => \Yii::app()->createUrl('/partner/order/index').'?filter=active',
        'Access' => $this->getAccessFilter()->checkAccess('order', 'index')
      ),
      'search' => array(
        'Title' => 'Поиск',
        'Url' => '',
        'Access' => ''
      ),
      'createbill' => array(
        'Title' => 'Выставить счет',
        'Url' => '',
        'Access' => ''
      ),
    );

    foreach ($this->bottomMenu as $key => $value)
    {
      $this->bottomMenu[$key]['Active'] = ($key == $active);
    }
  }
}