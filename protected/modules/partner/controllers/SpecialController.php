<?php

class SpecialController extends \partner\components\Controller
{
  public function actions()
  {
    if (Yii::app()->partner->getIsGuest())
    {
      $this->redirect(Yii::app()->createUrl('/partner/auth/index'));
    }
    if (Yii::app()->partner->getEvent()->IdName == 'rif13')
    {
      return array(
        'rooms' => 'partner\controllers\special\rif13\RoomsAction',
        'book' => 'partner\controllers\special\rif13\BookAction',
        'food' => 'partner\controllers\special\rif13\FoodAction',
        'clearbook' => 'partner\controllers\special\rif13\ClearbookAction',
        'bookinfo' => 'partner\controllers\special\rif13\BookinfoAction',
        'bookchanges' => 'partner\controllers\special\rif13\BookchangesAction',
      );
    }
    else
    {
      return array();
    }
  }

  public function initBottomMenu()
  {
    $this->bottomMenu = array(
      'index' => array(
        'Title' => 'Промо-коды',
        'Url' => \Yii::app()->createUrl('/partner/coupon/index'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'coupon', 'index')
      ),
      'users' => array(
        'Title' => 'Активированные промо-коды',
        'Url' => \Yii::app()->createUrl('/partner/coupon/users'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'coupon', 'users')
      ),
      'activation' => array(
        'Title' => 'Активация промо-кода',
        'Url' => \Yii::app()->createUrl('/partner/coupon/activation'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'coupon', 'activation')
      ),
      'generate' => array(
        'Title' => 'Генерация промо-кодов',
        'Url' => \Yii::app()->createUrl('/partner/coupon/generate'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'coupon', 'generate')
      ),
    );
  }
}
