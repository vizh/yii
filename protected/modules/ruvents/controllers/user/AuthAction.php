<?php
namespace ruvents\controllers\user;

use application\components\auth\identity\Password;
use ruvents\components\Action;
use ruvents\components\Exception;
use user\models\User;

class AuthAction extends Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $login = $request->getParam('Login'); // email or runet-id
        $password = $request->getParam('Password');

        $identity = new Password($login, $password);
        $identity->authenticate();

        if ($identity->errorCode !== \CUserIdentity::ERROR_NONE)
            throw new Exception(210);

        $user = User::model()->findByPk($identity->getId());
        if ($user === null)
            throw new Exception(202, [$identity->getName()]);

        $result = [];
        $this->getDataBuilder()->createUser($user);
        $this->getDataBuilder()->buildUserEmployment($user);
        $result['User'] = $this->getDataBuilder()->buildUserPhone($user);

        $this->renderJson($result);
    }
} 