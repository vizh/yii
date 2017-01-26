<?php
namespace event\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $RoleId
 * @property string $Color
 *
 * Описание вспомогательных методов
 * @method LinkRole   with($condition = '')
 * @method LinkRole   find($condition = '', $params = [])
 * @method LinkRole   findByPk($pk, $condition = '', $params = [])
 * @method LinkRole   findByAttributes($attributes, $condition = '', $params = [])
 * @method LinkRole[] findAll($condition = '', $params = [])
 * @method LinkRole[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LinkRole byId(int $id, bool $useAnd = true)
 * @method LinkRole byEventId(int $id, bool $useAnd = true)
 * @method LinkRole byRoleId(int $id, bool $useAnd = true)
 */
class LinkRole extends ActiveRecord
{
    /**
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventLinkRole';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
            'Role' => [self::BELONGS_TO, '\event\models\Role', 'RoleId']
        ];
    }
}