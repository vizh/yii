<?php
namespace api\controllers\pay;

class UrlAction extends \api\components\Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $payerRunetId = $request->getParam('PayerRunetId', null);
        if ($payerRunetId === null) {
            $payerRunetId = $request->getParam('PayerRocId', null);
        }

        /** @var $payer \user\models\User */
        $payer = \user\models\User::model()->byRunetId($payerRunetId)->find();
        if ($payer == null) {
            throw new \api\components\Exception(202, [$payerRunetId]);
        }

        $result = new \stdClass();
        $result->Url = \Yii::app()->createAbsoluteUrl('/pay/cabinet/auth',
            ['eventIdName' => $this->getEvent()->IdName, 'runetId' => $payer->RunetId, 'hash' => $payer->getHash()]);
        $this->setResult($result);
    }
}
