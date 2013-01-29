<?php

class TestController extends \application\components\controllers\MainController
{
  public function actionIndex()
  {
    $criteria = new \CDbCriteria();
        $criteria->with = array(
          'LinkAddress.Address.City',
        );
    $criteria->distinct = true;
    $criteria->select = '"City"."Id", "t"."Id"';

    $companies = \company\models\Company::model()->findAll($criteria);

    foreach ($companies as $comp)
    {
      echo $comp->LinkAddress->Address->City->Name . '<br>';
    }



    echo '<pre>';
    $logger = Yii::getLogger();
    print_r($logger->profilingResults);
    echo '</pre>';
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