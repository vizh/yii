<?php

class OrderController extends \partner\components\Controller
{
  const OrdersOnPage = 20;

  public function actions()
  {
    return array(
      'index' => '\partner\controllers\order\IndexAction',
      'create' => '\partner\controllers\order\CreateAction',
      'view' => '\partner\controllers\order\ViewAction',
      'search' => '\partner\controllers\order\SearchAction',
    );
  }

  public function initBottomMenu()
  {
    $this->bottomMenu = array(
      'inactive' => array(
        'Title' => 'Неоплаченные счета',
        'Url' => \Yii::app()->createUrl('/partner/order/index'),
        'Access' => $this->getAccessFilter()->checkAccess('order', 'index')
      ),
      'active' => array(
        'Title' => 'Оплаченные счета',
        'Url' => \Yii::app()->createUrl('/partner/order/index').'?filter=active',
        'Access' => $this->getAccessFilter()->checkAccess('order', 'index')
      ),
      'createbill' => array(
        'Title' => 'Выставить счет',
        'Url' => \Yii::app()->createUrl('/partner/order/create/'),
        'Access' => $this->getAccessFilter()->checkAccess('order', 'create')
      ),
      'search' => array(
        'Title' => 'Поиск счета',
        'Url' => \Yii::app()->createUrl('/partner/order/search'),
        'Access' => $this->getAccessFilter()->checkAccess('order', 'search')
      ),
    );
  }
}