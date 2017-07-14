<?php
namespace application\models\admin;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property string $Title
 * @property string $Password
 *
 * @property GroupUser[] $Users
 * @property GroupRole[] $Roles
 *
 * Описание вспомогательных методов
 * @method Group   with($condition = '')
 * @method Group   find($condition = '', $params = [])
 * @method Group   findByPk($pk, $condition = '', $params = [])
 * @method Group   findByAttributes($attributes, $condition = '', $params = [])
 * @method Group[] findAll($condition = '', $params = [])
 * @method Group[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Group byId(int $id, bool $useAnd = true)
 * @method Group byTitle(string $title, bool $useAnd = true)
 */
class Group extends ActiveRecord
{
    /**
     * @param string $className
     * @return Group
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'AdminGroup';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [
            'Users' => [self::HAS_MANY, '\application\models\admin\GroupUser', 'GroupId'],
            'Roles' => [self::HAS_MANY, '\application\models\admin\GroupRole', 'GroupId']
        ];
    }

    /**
     * @param int $userId
     * @param bool $useAnd
     *
     * @return Group
     */
    public function byUserId($userId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"Users"."UserId" = :UserId';
        $criteria->params = ['UserId' => $userId];
        $criteria->with = ['Users' => ['together' => true, 'select' => false]];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }
}
