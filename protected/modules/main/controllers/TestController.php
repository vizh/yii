<?php
class TestController extends \CController
{
  public function actionIndex()
  {
    $user  = \Yii::app()->user->getCurrentUser();
    $role  = \event\models\Role::model()->findByPk(1);
    $event = \event\models\Event::model()->findByPk(431);
    $event->registerUser($user, $role);
  }
}
