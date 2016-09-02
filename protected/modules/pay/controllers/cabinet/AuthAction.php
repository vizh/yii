<?php
namespace pay\controllers\cabinet;

use Yii;

class AuthAction extends \pay\components\Action
{
    public function run($eventIdName, $runetId, $hash)
    {
        /** @var $user \user\models\User */
        $user = \user\models\User::model()->byRunetId($runetId)->find();

        if ($user === null || !$user->checkHash($hash)) {
            throw new \CHttpException(404);
        }

        if (Yii::app()->user->getCurrentUser() === null || Yii::app()->user->getCurrentUser()->RunetId != $runetId) {
            $identity = new \application\components\auth\identity\RunetId($runetId);
            $identity->authenticate();
            if ($identity->errorCode == \application\components\auth\identity\Base::ERROR_NONE) {
                if (!$user->Temporary) {
                    Yii::app()->user->login($identity, $identity->GetExpire());
                } else {
                    Yii::app()->tempUser->login($identity);
                }
            } else {
                throw new \CHttpException(404);
            }
        }

        // Если в запросе указана локаль, то нам нужно проксировать её настраницу оплат
        $lang = Yii::app()
            ->getRequest()
            ->getParam('lang');

        $prms = [];
        if ($lang !== null) {
            $prms = ['lang' => $lang];
        }

        $this->getController()->redirect($this->getController()->createUrl('/pay/cabinet/index', $prms));
    }
}
