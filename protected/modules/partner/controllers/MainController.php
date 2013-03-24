<?php

class MainController extends \partner\components\Controller
{
  public function actions()
  {
    return array(
      'index' => 'partner\controllers\main\IndexAction',
      'pay' => 'partner\controllers\main\PayAction',
    );
  }

  public function initBottomMenu()
  {
    $this->bottomMenu = array(
      'index' => array(
        'Title' => 'Участники',
        'Url' => \Yii::app()->createUrl('/main/index'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'main', 'index')
      ),
      'pay' => array(
        'Title' => 'Фин. статистика',
        'Url' => \Yii::app()->createUrl('/main/pay'),
        'Access' => $this->getAccessFilter()->checkAccess('partner', 'main', 'pay')
      )
    );
  }
}