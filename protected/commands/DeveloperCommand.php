<?php

use api\models\Account as ApiAccount;
use application\components\console\BaseConsoleCommand;
use application\components\Exception;
use event\models\Event;
use partner\models\Account as PartnerAccount;
use user\models\User;

class DeveloperCommand extends BaseConsoleCommand
{
    public function actionBootstrap()
    {
        if (YII_DEBUG === false) {
            echo "Нельзя запускать процесс инициализации базы в PRODUCTION режиме!\n";
            return;
        }

        // Тестовое мероприятие
        $event = Event::model()->findByPk(1) ?: new Event();
        $event->IdName = 'test';
        $event->Title = 'Проверочное мероприятие';
        if (false === $event->save()) {
            throw new Exception($event);
        }

        // Партнёр-супервизор
        $partner = PartnerAccount::model()->byLogin('root')->find() ?: new PartnerAccount();
        $partner->Login = 'root';
        $partner->Role = PartnerAccount::ROLE_ADMIN_EXTENDED;
        $partner->EventId = $event->Id;
        $partner->setPassword('922FEEhBK9');
        $partner->save();

        // Администратор
        $user = User::model()->findByPk(1) ?: new User();
        $user->Email = 'admin@runet-id.com';
        $user->changePassword('thyRi6xmcLWB');
        if (false === $user->save()) {
            throw new Exception($user);
        }

        // Аккаунт API для OAuth авторизации на самом себе
        $account = ApiAccount::model()->findByPk(1) ?: new ApiAccount();
        $account->Key = 'runetid';
        $account->Secret = 'RxpaG5KhY9nGUitHqlauA9Rgy';
        $account->Role = ApiAccount::ROLE_SUPERVISOR;
        $account->EventId = $event->Id;
        $account->save();
    }
}