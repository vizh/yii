<?php

namespace paperless\models;

use application\components\ActiveRecord;
use event\models\Role;

/**
 * @property int $EventId
 * @property int $RoleId
 *
 * @property Event $Event
 * @property Role $Role
 *
 * Описание вспомогательных методов
 * @method EventLinkRole   with($condition = '')
 * @method EventLinkRole   find($condition = '', $params = [])
 * @method EventLinkRole   findByPk($pk, $condition = '', $params = [])
 * @method EventLinkRole   findByAttributes($attributes, $condition = '', $params = [])
 * @method EventLinkRole[] findAll($condition = '', $params = [])
 * @method EventLinkRole[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method EventLinkRole byEventId(int $id, bool $useAnd = true)
 * @method EventLinkRole byRoleId(int $id, bool $useAnd = true)
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