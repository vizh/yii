<?php
namespace api\controllers\user;

use api\components\Action;
use api\components\Exception;

class LoginAction extends Action
{
    public function run()
    {
        $user = $this->getRequestedUser();

        if ($user->Email !== $this->getRequestedParam('Email')) {
            throw new Exception(210, $this->getRequestedParam('Email'));
        }

        if ($user->checkLogin($this->getRequestedParam('Password')) === false) {
            throw new Exception(201);
        }

        $userData = $this
            ->getDataBuilder()
            ->createUser($user);

        $this->setResult($userData);
    }
}
