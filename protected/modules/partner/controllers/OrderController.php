<?php

class OrderController extends \partner\components\Controller
{
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
      'index' => array(
        'Title' => 'Поиск счетов',
        'Url' => \Yii::app()->createUrl('/partner/order/search'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'order', 'search')
      ),
      /*'inactive' => array(
        'Title' => 'Неоплаченные счета',
        'Url' => \Yii::app()->createUrl('/partner/order/index'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'order', 'index')
      ),
      'active' => array(
        'Title' => 'Оплаченные счета',
        'Url' => \Yii::app()->createUrl('/partner/order/index').'?filter=active',
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'order', 'index')
      ),*/
      'createbill' => array(
        'Title' => 'Выставить счет',
        'Url' => \Yii::app()->createUrl('/partner/order/create/'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'order', 'create')
      ),
    );
  }
}