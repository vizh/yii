<?php

use api\models\Account as ApiAccount;
use application\components\console\BaseConsoleCommand;
use application\components\Exception;
use application\models\admin\Group;
use application\models\admin\GroupRole;
use application\models\admin\GroupUser;
use event\models\Event;
use partner\models\Account as PartnerAccount;
use user\models\User;

class DeveloperCommand extends BaseConsoleCommand
{
    public function actionBootstrap()
    {
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
        $user->Email = 'admin@ruvents.com';
        $user->changePassword('thyRi6xmcLWB');
        if (false === $user->save()) {
            throw new Exception($user);
        }

        // Заводим административные группы и назначаем нашего пользователя их членом
        foreach (['Administrator' => 'admin', 'Booker' => 'booker', 'RoomManager' => 'roommanager'] as $title => $role) {
            $group = Group::model()
                ->byTitle($title)
                ->find();

            if ($group === null) {
                $group = new Group();
                $group->Title = $title;
                $group->save();
            }

            $groupUser = GroupUser::model()
                ->byUserId($user->Id)
                ->byGroupId($group->Id)
                ->find();

            if ($groupUser === null) {
                $groupUser = new GroupUser();
                $groupUser->UserId = $user->Id;
                $groupUser->GroupId = $group->Id;
                $groupUser->save();
            }

            $groupRole = GroupRole::model()
                ->byCode($role)
                ->find();

            if ($groupRole === null) {
                $groupRole = new GroupRole();
            }

            $groupRole->Code = $role;
            $groupRole->GroupId = $group->Id;
            $groupRole->save();
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