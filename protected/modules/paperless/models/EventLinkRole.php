<?php

namespace paperless\models;

use application\components\ActiveRecord;
use event\models\Role;

/**
 * @property integer $EventId
 * @property integer $RoleId
 *
 * @property Event $Event
 * @property Role $Role
 */
class EventLinkRole extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'PaperlessEventLinkRole';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['EventId, RoleId', 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, Event::className(), ['EventId']],
            'Role' => [self::BELONGS_TO, Role::className(), ['RoleId']],
        ];
    }
}