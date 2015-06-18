<?php
namespace event\widgets;

use event\components\WidgetPosition;
use event\models\Participant;
use event\models\Role;


/**
 * Class FastRegistration
 * @package event\widgets
 *
 * @property int $DefaultRoleId
 * @property string $FastRegistrationText
 * @property string $FastRegistrationButtonText
 */
class FastRegistration extends \event\components\Widget
{
    public function getAttributeNames()
    {
        return [
            'DefaultRoleId',
            'FastRegistrationText',
            'FastRegistrationButtonText'
        ];
    }

    public function process()
    {
        $request = \Yii::app()->getRequest();
        if (!\Yii::app()->user->isGuest && ($request->getIsPostRequest() || \Yii::app()->user->getIsRecentlyLogin()))
        {
            $role = Role::model()->findByPk($this->DefaultRoleId);
            $this->event->registerUser(\Yii::app()->user->getCurrentUser(), $role, true);
            \Yii::app()->getController()->refresh();
        }
    }

    public function run()
    {
        if ( !$this->event->closeRegistration()) {
            $isParticipant = false;
            if (!\Yii::app()->user->isGuest) {
                $isParticipant = Participant::model()->byUserId(\Yii::app()->user->getId())->byEventId($this->event->Id)->exists();
            }

            $this->render('registration-fast', [
                'isParticipant' => $isParticipant,
                'event' => $this->event,
                'role' => Role::model()->findByPk($this->DefaultRoleId)
            ]);
        }
    }

    public function getPosition()
    {
        return WidgetPosition::Content;
    }

    public function getTitle()
    {
        return \Yii::t('app', 'Быстрая регистрация на мероприятии');
    }
}
