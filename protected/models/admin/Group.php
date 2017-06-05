<?php
namespace application\models\admin;

/**
 * @property int $Id
 * @property string $Title
 * @property string $Password
 *
 * @property GroupUser[] $Users
 * @property GroupRole[] $Roles
 */
class Group extends \CActiveRecord
{
    /**
     * @param string $className
     * @return Group
     */
    public static function model($className = __CLASS__)
    {
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
            'Roles' => [self::HAS_MANY, '\application\models\admin\GroupRole', 'GroupId'],
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
