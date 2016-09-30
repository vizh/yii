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
            ->byEmail($this->getRequestParam('Email'))
            ->find();

        if ($user === null) {
            throw new Exception(210, $this->getRequestParam('Email'));
        }

        if ($user->checkLogin($this->getRequestParam('Password')) === false) {
            throw new Exception(201);
        }

        // Если в процессе авторизации передан DeviceToken, то подписываем пользователя на Push Notification
        if ($this->hasRequestParam('DeviceToken') && !$user->hasDevice($this->getRequestParam('DeviceToken'))) {
            if ($this->getRequestParam('DeviceType') !== 'iOS')
                throw new Exception(100, 'Пока работает только для iOS');

            $device = $user->addDevice(
                $this->getRequestParam('DeviceType'),
                $this->getRequestParam('DeviceToken')
            );

            if ($device->hasErrors()) {
                $this->setErrorResult($device->errors);
            }
        }

        $userData = $this
            ->getDataBuilder()
            ->createUser($user);

        $this->setResult($userData);
    }
}
