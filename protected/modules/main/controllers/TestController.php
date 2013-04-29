<?php
class TestController extends \CController
{
  public function actionIndex()
  {
    $event = \event\models\Event::model()->findByPk(422);
    $role  = \event\models\Role::model()->findByPk(1);
    $user  = \user\models\User::model()->byRunetId(454)->find();
    
    $mail = new \mail\components\mail\RIF13();
    $mail->event = $event;
    $mail->role  = $role;
    $mail->user  = $user;
    
    $mailer = new \mail\components\Mailer();
    $mailer->send($mail, $user->Email);
  }
}
