<?php
class TestController extends \CController
{
  public function actionIndex()
  {
    $event = \event\models\Event::model()->findByPk(423);
    $role  = \event\models\Role::model()->findByPk(1);
    $user  = \user\models\User::model()->byRunetId(454)->find();
    $event->registerUser($user, $role);
  }
}
