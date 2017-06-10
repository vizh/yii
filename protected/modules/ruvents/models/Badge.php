<?php
namespace ruvents\models;

use application\components\ActiveRecord;
use event\models\Part;
use event\models\Role;
use user\models\User;

/**
 * @property int $Id
 * @property int $OperatorId
 * @property int $EventId
 * @property int $PartId
 * @property int $UserId
 * @property int $RoleId
 * @property string $CreationTime
 *
 * @property Role $Role
 * @property User $User
 * @property Part $Part
 *
 * Описание вспомогательных методов
 * @method Badge   with($condition = '')
 * @method Badge   find($condition = '', $params = [])
 * @method Badge   findByPk($pk, $condition = '', $params = [])
 * @method Badge   findByAttributes($attributes, $condition = '', $params = [])
 * @method Badge[] findAll($condition = '', $params = [])
 * @method Badge[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Badge byId(int $id, bool $useAnd = true)
 * @method Badge byOperatorId(int $id, bool $useAnd = true)
 * @method Badge byEventId(int $id, bool $useAnd = true)
 * @method Badge byPartId(int $id, bool $useAnd = true)
 * @method Badge byUserId(int $id, bool $useAnd = true)
 * @method Badge byRoleId(int $id, bool $useAnd = true)
 */
class Badge extends ActiveRecord
{
    public $CountForCriteria;
    public $DateForCriteria;

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
        return 'RuventsBadge';
    }

    public function relations()
    {
        return [
            'Role' => [self::BELONGS_TO, '\event\models\Role', 'RoleId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
            'Part' => [self::BELONGS_TO, '\event\models\Part', 'PartId'],
            'Operator' => [self::BELONGS_TO, '\ruvents\models\Operator', 'OperatorId']
        ];
    }
}