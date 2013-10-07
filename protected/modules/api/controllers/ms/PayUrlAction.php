<?php

class PayUrlAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $externalId = $request->getParam('ExternalId');

    $user = new \user\models\User();
    $url = $user->getFastauthUrl(Yii::app()->createUrl('/pay/cabinet/register', ['eventIdName' => $this->getEvent()->IdName]));


    $this->setResult(['PayUrl' => $url]);
  }
}