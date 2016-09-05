<?php
namespace api\controllers\user;

use api\components\Action;
use api\components\Exception;
use user\models\User;

class LoginAction extends Action
{
    public function run()
    {
        $user = User::model()
            ->byEmail($this->getRequestedParam('Email'))
            ->find();

        if ($user === null)
            throw new Exception(210, $this->getRequestedParam('Email'));

        if ($user->checkLogin($this->getRequestedParam('Password')) === false) {
            throw new Exception(201);
        }

        $userData = $this
            ->getDataBuilder()
            ->createUser($user);

        $this->setResult($userData);
    }
}
