<?php
namespace api\controllers\user;

use api\components\Action;
use api\components\Exception;
use oauth\models\AccessToken;
use user\models\User;

class AuthAction extends Action
{
    public function run()
    {
        /** @var $accessToken AccessToken */
        $accessToken = AccessToken::model()
            ->byToken($this->getRequestParam('token'))
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
