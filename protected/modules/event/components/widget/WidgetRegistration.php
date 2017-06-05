<?php
namespace event\components\widget;

use event\components\Widget;
use event\components\WidgetPosition;
use event\models\Role;

/**
 * Class WidgetRegistration
 * @package event\components\widget
 *
 * @property int $WidgetRegistrationPositionTab
 * @property string $WidgetRegistrationParticipantRoles
 * @property string $WidgetRegistrationParticipantMessage
 */
abstract class WidgetRegistration extends Widget
{
    /**
     * @return array
     */
    public function getAttributeNames()
    {
        return [
            'WidgetRegistrationPositionTab',
            'WidgetRegistrationParticipantRoles',
            'WidgetRegistrationParticipantMessage'
        ];
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        if (isset($this->WidgetRegistrationPositionTab) && $this->WidgetRegistrationPositionTab == 1) {
            return WidgetPosition::Tabs;
        }
        return WidgetPosition::Content;
    }

    /**
     * Роли, которые не являются ролями участия
     * @return Role[]
     */
    public function getParticipantRoles()
    {
        if (isset($this->WidgetRegistrationParticipantRoles)) {
            $pk = explode(',', $this->WidgetRegistrationParticipantRoles);
            return Role::model()->findAllByPk($pk);
        }
        return [];
    }
}