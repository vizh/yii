<?php
namespace application\models\admin;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property string $GroupId
 * @property string $UserId
 *
 * @property GroupUser[] $Users
 * @property GroupRole[] $Roles
 *
 * Описание вспомогательных методов
 * @method GroupUser   with($condition = '')
 * @method GroupUser   find($condition = '', $params = [])
 * @method GroupUser   findByPk($pk, $condition = '', $params = [])
 * @method GroupUser   findByAttributes($attributes, $condition = '', $params = [])
 * @method GroupUser[] findAll($condition = '', $params = [])
 * @method GroupUser[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method GroupUser byId(int $id, bool $useAnd = true)
 * @method GroupUser byUserId(int $id, bool $useAnd = true)
 * @method GroupUser byGroupId(int $id, bool $useAnd = true)
 */
class GroupUser extends ActiveRecord
{
    /**
     * @param string $className
     * @return GroupUser
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'AdminGroupUser';
    }

    public function primaryKey()
    {
        return 'Id';
    }
}
