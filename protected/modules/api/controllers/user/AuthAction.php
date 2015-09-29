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
        $request = \Yii::app()->getRequest();
        $token = $request->getParam('token');
        /** @var $accessToken AccessToken */
        $accessToken = AccessToken::model()->byToken($token)->find();

        if (empty($accessToken)) {
            \Yii::log('Token: ' . $token, \CLogger::LEVEL_ERROR);
            throw new Exception(222);
        }
        if ($accessToken->AccountId != $this->getAccount()->Id) {
            throw new Exception(223);
        }
        /** @var $user User*/
        $user = User::model()->findByPk($accessToken->UserId);
        if (empty($user)) {
            throw new Exception(224);
        }

        $this->getAccount()->getDataBuilder()->createUser($user);
        $this->getAccount()->getDataBuilder()->buildUserContacts($user);
        $this->getAccount()->getDataBuilder()->buildUserEmployment($user);
        $this->getAccount()->getDataBuilder()->buildUserEvent($user);
        $this->getController()->setResult($this->getAccount()->getDataBuilder()->buildUserBadge($user));
    }
}
