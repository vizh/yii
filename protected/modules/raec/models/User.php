<?php
namespace raec\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $CommissionId
 * @property int $UserId
 * @property int $RoleId
 * @property string $JoinTime
 * @property string $ExitTime
 *
 * @property \user\models\User $User
 * @property \raec\models\Role $Role
 *
 * Описание вспомогательных методов
 * @method User   with($condition = '')
 * @method User   find($condition = '', $params = [])
 * @method User   findByPk($pk, $condition = '', $params = [])
 * @method User   findByAttributes($attributes, $condition = '', $params = [])
 * @method User[] findAll($condition = '', $params = [])
 * @method User[] findAllByAttributes($attributes, $condition = '', $params = [])
 * @method User byId(int $id, bool $useAnd = true)
 * @method User byCommissionId(int $id, bool $useAnd = true)
 * @method User byUserId(int $id, bool $useAnd = true)
 * @method User byRoleId(int $id, bool $useAnd = true)
 */
class User extends ActiveRecord
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
        return 'CommissionUser';
    }

    public function relations()
    {
        return [
            'Commission' => [self::BELONGS_TO, '\raec\models\Commission', 'CommissionId'],
            'Role' => [self::BELONGS_TO, '\raec\models\Role', 'RoleId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId']
        ];
    }
}
