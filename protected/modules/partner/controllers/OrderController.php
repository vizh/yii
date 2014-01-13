<?php

class OrderController extends \partner\components\Controller
{
  public function actions()
  {
    return array(
      'index' => '\partner\controllers\order\IndexAction',
      'create' => '\partner\controllers\order\CreateAction',
      'view' => '\partner\controllers\order\ViewAction',
      'edit' => '\partner\controllers\order\EditAction'
    );
  }

  public function initBottomMenu()
  {
    $this->bottomMenu = [
      'index' => [
        'Title' => 'Поиск счетов',
        'Url' => \Yii::app()->createUrl('/partner/order/index'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'order', 'search')
      ],
      'createbill' => [
        'Title' => 'Выставить счет',
        'Url' => \Yii::app()->createUrl('/partner/order/create/'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'order', 'create')
      ],
    ];
  }
}