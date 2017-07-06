<?php
namespace api\controllers\user;

use api\components\Action;
use api\components\Exception;
use application\hacks\AbstractHack;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\ApiAction;
use user\models\User;

class LoginAction extends Action
{

    /**
     * @ApiAction(
     *     controller="User",
     *     title="Авторизация",
     *     description="Авторизация, проверка связки Email и Password.",
     *     request=@Request(
     *          method="GET",
     *          url="/user/login",
     *          body="",
     *          params={
     *              @Param(title="Email", type="строка", defaultValue="", description="Email. Обязательно."),
     *              @Param(title="Password", type="строка", defaultValue="", description="Пароль. Обязательно."),
     *              @Param(title="DeviceType", type="строка", defaultValue="", description="Тип регистрируемого устройства пользователя. Обязателен, если указан параметр DeviceToken. Возможные значения: iOS, Android."),
     *              @Param(title="DeviceToken", type="строка", defaultValue="", description="Уникальный идентификатор устройства для получения push-уведомлений.")
     *          },
     *          response=@Response(body="{
    'RunetId': 'идентификатор',
    'LastName': 'фамилия',
    'FirstName': 'имя',
    'FatherName': 'отчество',
    'CreationTime': 'дата регистрации пользователя',
    'Photo': 'объект Photo({Small, Medium, Large}) - ссылки на 3 размера фотографии пользователя',
    'Email': 'email пользователя',
    'Gender': 'пол посетителя. Возможные значения: null, male, female',
    'Phones': 'массив с телефонами пользователя, если заданы',
    'Work': 'объект с данными о месте работы пользователя',
    'Status': 'объект с данными о статусе пользователя на мероприятии'
    }")
     *     )
     * )
     */
    public function run()
    {
        // Позволяем реализовать кастомный механизм авторизации. Помним, что у нас есть мультиаккаунты,
        // что данный хак не будет отрабатывать если для них не указан корректный EventId.
        $user = AbstractHack::getByEvent($this->getAccount()->Event)->apiCustomLogin(
            $this->getRequestParam('Email'),
            $this->getRequestParam('Password')
        );

        // Если кастомный механизм авторизации не определён, или завершён неудачей, то пробуем классическую схему
        if ($user === null) {
            $user = User::model()
                ->byEmail($this->getRequestParam('Email'))
                ->byVisible()
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
