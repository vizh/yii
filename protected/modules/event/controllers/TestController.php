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

//    \Yii::app()->onUserRegister = array($this, 'TestEventRegister');
//
//    \Yii::app()->onUserRegister = array($this, 'TestEventRegister2');
//
//    $event = new CModelEvent($this);
//    \Yii::app()->onUserRegister($event);

    //\user\models\User::model()->attachEventHandler('onRegister', array($this, 'TestEventRegister'));

    \user\models\User::model()->onRegister = array($this, 'TestEventRegister');


    $user = new \user\models\User();
    $user->LastName = 'Korotov';
    $user->FirstName = 'Andrey';
    $user->Password = '12345';
    $user->Email = 'korotov@test.ru';
    $user->Register();
  }

  public function actionView()
  {
    $user = \user\models\User::model()->findByPk(5);

    print_r($user->getAttributes());
  }

  public function TestEventRegister($event)
  {
    //print_r($event);
    echo 'success test';
  }

  public function TestEventRegister2()
  {
    echo 'success test2';
  }
}
