<?php
class TestController extends \CController
{
  public function actionIndex()
  {
    $runetIdList = array(321,122262,454);
    $role  = \event\models\Role::model()->findByPk(1);
    $event = \event\models\Event::model()->findByPk(431);
    foreach ($runetIdList as $runetId)
    {
      $user = \user\models\User::model()->byRunetId($runetId)->find();
      $event->registerUser($user, $role);
    }
  }
}
