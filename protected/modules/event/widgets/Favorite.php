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
            $event = $this->getEvent();
            if ($event->hasParticipant($user->getId()) === false) {
                $event->registerUser($user->getCurrentUser(), Role::model()->findByPk(Role::VIRTUAL_ROLE_ID), true);
            }
        }
    }

    public function run()
    {
        // Ничего не делаем, если регистрация уже закрыта
        if ($this->getEvent()->isRegistrationClosed()) {
            return;
        }

        $user = Yii::app()->getUser();
        $event = $this->getEvent();

        if (!$event->hasParticipant($user->getCurrentUser())) {
            $this->render('favorite', [
                'role' => Role::model()->findByPk(Role::VIRTUAL_ROLE_ID),
                'event' => $event,
                'user' => $user
            ]);
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
