<?php
namespace api\controllers\user;

use api\components\Action;
use api\components\Exception;
use oauth\models\AccessToken;
use user\models\User;
use Yii;

class AuthAction extends Action
{
    public function run()
    {
        $token = Yii::app()
            ->getRequest()
            ->getParam('token');

        if ($token === null) {
            throw new Exception(222);
        }

        /** @var $accessToken AccessToken */
        $accessToken = AccessToken::model()
            ->byToken($token)
            ->find();

        if ($accessToken === null) {
            throw new Exception(222);
        }

        if ($accessToken->AccountId !== $this->getAccount()->Id) {
            throw new Exception(223);
        }

        $user = User::model()
            ->findByPk($accessToken->UserId);

        if ($user === null) {
            throw new Exception(224);
        }

        $usedData = $this
            ->getDataBuilder()
            ->createUser($user);

        $this->setResult($usedData);
    }
}
