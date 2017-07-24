<?php
namespace application\models\admin;

/**
 * @property int $Id
 * @property int $GroupId
 * @property string $Code
 * @property string $Title
 */

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $GroupId
 * @property string $Code
 * @property string $Title
 *
 * Описание вспомогательных методов
 * @method GroupRole   with($condition = '')
 * @method GroupRole   find($condition = '', $params = [])
 * @method GroupRole   findByPk($pk, $condition = '', $params = [])
 * @method GroupRole   findByAttributes($attributes, $condition = '', $params = [])
 * @method GroupRole[] findAll($condition = '', $params = [])
 * @method GroupRole[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method GroupRole byId(int $id, bool $useAnd = true)
 * @method GroupRole byGroupId(int $id, bool $useAnd = true)
 * @method GroupRole byCode(string $code, bool $useAnd = true)
 * @method GroupRole byTitle(string $title, bool $useAnd = true)
 */
class GroupRole extends ActiveRecord
{
    /**
     * @param string $className
     * @return GroupRole
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'AdminGroupRole';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [];
    }
}
