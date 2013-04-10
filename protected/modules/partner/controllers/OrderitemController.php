<?php

class OrderitemController extends \partner\components\Controller
{
  public function actions()
  {
    return array(
      'index' => '\partner\controllers\orderitem\IndexAction',
      'create' => '\partner\controllers\orderitem\CreateAction',
      'redirect' => '\partner\controllers\orderitem\RedirectAction',
      'activateajax' => '\partner\controllers\orderitem\ActivateAjaxAction'
    );
  }

  public function initBottomMenu()
  {
    $this->bottomMenu = array(
      'index' => array(
        'Title' => 'Заказы',
        'Url' => \Yii::app()->createUrl('/partner/orderitem/index'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'orderitem', 'index')
      ),
      /*'create' => array(
        'Title' => 'Добавить заказ',
        'Url' => \Yii::app()->createUrl('/partner/orderitem/create'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'orderitem', 'create')
      ),*/
      'redirect' => array(
        'Title' => 'Перенести заказ',
        'Url' => \Yii::app()->createUrl('/partner/orderitem/redirect'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'orderitem', 'redirect')
      ),
    );
  }
}
