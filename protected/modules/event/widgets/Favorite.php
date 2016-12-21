<?php
namespace event\widgets;

use event\components\Widget;
use event\components\WidgetPosition;
use event\models\Role;
use Yii;

/**
 * @package event\widgets
 */
class Favorite extends Widget
{
    public function process()
    {
        $user = Yii::app()->getUser();
        if ($user->getIsGuest() === false && (Yii::app()->getRequest()->getIsPostRequest() || $user->getIsRecentlyLogin())) {
            $this->getEvent()->registerUser($user->getCurrentUser(), Role::model()->findByPk(Role::VIRTUAL_ROLE_ID), true);
            Yii::app()->getController()->refresh();
        }
    }

    public function run()
    {
        // Ничего не делаем, если регистрация уже закрыта
        if ($this->getEvent()->isRegistrationClosed()) {
            return;
        }

        $user = Yii::app()->getUser();
        $role = Role::model()->findByPk(Role::VIRTUAL_ROLE_ID);
        $event = $this->getEvent();

        // Если пользователь не авторизован, то предлагаем ему заманушку для авторизации
        if ($user->getIsGuest()) {
            $this->render('favorite', [
                'role' => $role,
                'event' => $event
            ]);

            return;
        }

        // Если авторизованный посетитель не зарегистрирован на мероприятие, то по-тихому регистрируем его
        if ($event->hasParticipant($user->getId()) === false) {
            $event->registerUser($user->getCurrentUser(), $role, true);
        }
    }

    public function getPosition()
    {
        return WidgetPosition::Content;
    }

    public function getTitle()
    {
        return Yii::t('app', 'Добавление мероприятия в изобранное');
    }
}
