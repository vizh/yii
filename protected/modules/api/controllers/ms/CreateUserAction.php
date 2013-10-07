<?php

class CreateUserAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $externalId = $request->getParam('ExternalId');
    $email = $request->getParam('Email');
    $lastName = $request->getParam('LastName');
    $firstName = $request->getParam('FirstName');
    $company = $request->getParam('Company');
    $position = $request->getParam('Position');

    $user = new \user\models\User();

    $url = $user->getFastauthUrl(Yii::app()->createUrl('/pay/cabinet/register', ['eventIdName' => $this->getEvent()->IdName]));

    $this->setResult(['PayUrl' => $url]);
  }
}