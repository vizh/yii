<?php

class TestController extends \application\components\controllers\MainController
{
  public function actionIndex()
  {
//    $password = 'test1234';
//
//    $pbkdf2 = new \application\components\utility\Pbkdf2();
//    $hash = $pbkdf2->createHash($password);
//
//    echo $hash;
//
//    $check = \application\components\utility\Pbkdf2::validatePassword($password, $hash);
//
//    echo '<br><br><br><br>';
//
//    var_dump($check);

//    echo user\models\Gender::Male . '<br>';
//
//    $user = \user\models\User::model()->find();
//
//    var_dump($user);

    \Yii::app()->onUserRegister = array($this, 'TestEventRegister');

    $event = new CModelEvent(\Yii::app());
    \Yii::app()->onUserRegister($event);

  }

  public function TestEventRegister()
  {
    echo 'success test';
  }

  public function TestEventRegister2()
  {
    echo 'success test2';
  }
}
