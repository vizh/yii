<?php
namespace api\controllers\user;

use api\components\Action;
use api\components\Exception;
use application\hacks\AbstractHack;
use user\models\User;

class LoginAction extends Action
{
    public function run()
    {
        // Позволяем реализовать кастомный механизм авторизации
        $user = AbstractHack::getByEvent($this->getEvent())->apiCustomLogin(
            $this->getRequestParam('Email'),
            $this->getRequestParam('Password')
        );

        // Если кастомный механизм авторизации не определён, или завершён неудачей, то пробуем классическую схему
        if ($user === null) {
            $user = User::model()
                ->byEmail($this->getRequestParam('Email'))
                ->find();

            if ($user !== null && $user->checkLogin($this->getRequestParam('Password')) === false) {
                throw new Exception(201);
            }
        }

        if ($user === null) {
            throw new Exception(210, $this->getRequestParam('Email'));
        }

        // Если передан DeviceToken, то подписываем пользователя на уведомления
        if ($this->hasRequestParam('DeviceToken') && !$user->hasDevice($this->getRequestParam('DeviceToken'))) {
            if ($this->getRequestParam('DeviceType') !== 'iOS') {
                throw new Exception(100, 'Пока работает только для iOS');
            }

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
