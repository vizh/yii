<?php
namespace api\controllers\user;

use api\components\Action;
use user\models\User;
use api\components\Exception;

class LoginAction extends Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();

        $login = $this->getLoginParam();
        $password = $request->getParam('Password');

        $user = User::model()->byRunetId($login)->byEmail($login, 'OR')->find();
        if ($user === null) {
            throw new Exception(211, [$login]);
        }

        if (!$user->checkLogin($password)) {
            throw new Exception(201);
        }

        $userData = $this
            ->getDataBuilder()
            ->createUser($user);

        $this->setResult($userData);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function getLoginParam()
    {
        $request = \Yii::app()->getRequest();
        foreach (['Login', 'Email', 'RunetId'] as $name) {
            $login = $request->getParam($name);
            if (!empty($login)) {
                return trim($login);
            }
        }
        throw new Exception(110);
    }
}
