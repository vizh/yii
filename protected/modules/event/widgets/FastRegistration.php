<?php
namespace event\widgets;

use event\components\WidgetPosition;
use event\models\Role;
use Yii;

/**
 * Class FastRegistration
 *
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
        $user = Yii::app()->getUser();
        if ($user->getIsGuest() === false && (Yii::app()->getRequest()->getIsPostRequest() || $user->getIsRecentlyLogin())) {
            $this->getEvent()->registerUser($user->getCurrentUser(), Role::model()->findByPk($this->getDefaultRoleId()), true);
            Yii::app()->getController()->refresh();
        }
    }

    public function run()
    {
        if ($this->event->isRegistrationClosed() === false) {
            $this->render('registration-fast', [
                'isParticipant' => Yii::app()->getUser()->getIsGuest() === false
                    && $this->getEvent()->hasParticipant(Yii::app()->getUser()->getId()),
                'event' => $this->getEvent(),
                'role' => Role::model()->findByPk($this->getDefaultRoleId())
            ]);
        }
    }

    public function getPosition()
    {
        return WidgetPosition::Content;
    }

    public function getTitle()
    {
        return Yii::t('app', 'Быстрая регистрация на мероприятии');
    }

    private function getDefaultRoleId()
    {
        return isset($this->DefaultRoleId)
            ? $this->DefaultRoleId
            : Role::VIRTUAL_ROLE_ID;
    }
}
