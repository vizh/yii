<?php

namespace application\hacks;

use api\models\Account;
use event\models\Event;
use user\models\User;

class AbstractHack
{
    /**
     * @param Event|null $event
     * @return AbstractHack
     */
    public static function getByEvent($event)
    {
        /** @var AbstractHack $hack */
        static $hack;

        if ($hack === null) {
            $hack = $event !== null && file_exists(sprintf('%s/%s/Hack.php', __DIR__, $event->IdName)) && class_exists($definition = "\\application\\hacks\\{$event->IdName}\\Hack")
                ? new $definition
                : new self();

            $hack->init();
        }

        return $hack;
    }

    public function init()
    {

    }

    public function onPartnerMenuBuild(array $items)
    {
        return $items;
    }

    public function onPartnerRegisterControllerActions(array $actions)
    {
        return $actions;
    }

    public function getCustomDataBuilder(Account $account)
    {
        return null;
    }

    /**
     * Вызывается в момент авторизации используя метод user/login. Должна вернуть либо null,
     * либо новый экземлпяр User. Можно использовать для проверки логина и пароля через внешние
     * сервисы. Свобода для творчества.
     *
     * @param $email string
     * @param $password string
     * @return User|null
     */
    public function apiCustomLogin(/** @noinspection PhpUnusedParameterInspection */ $email, $password)
    {
        return null;
    }
}