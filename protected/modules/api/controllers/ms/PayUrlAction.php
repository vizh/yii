<?php
namespace api\controllers\ms;

class PayUrlAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $externalId = $request->getParam('ExternalId');

    $externalUser = \api\models\ExternalUser::model()
        ->byExternalId($externalId)->byPartner(\MsController::Partner)->find();
    if ($externalUser === null)
      throw new \api\components\Exception(3003, array($externalId));


    $url = $externalUser->User->getFastauthUrl(\Yii::app()->createUrl('/pay/cabinet/register', ['eventIdName' => $this->getEvent()->IdName]));

    $this->setResult(['PayUrl' => $url]);
  }
}