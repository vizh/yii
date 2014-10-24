<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 16.09.14
 * Time: 12:13
 */

namespace raec\models;
use user\models\User;


/**
 * Class BriefLinkUser
 * @package raec\models
 * @property int $Id
 * @property int $UserId
 * @property int $BriefId
 * @property int $RoleId
 * @property Brief $Brief
 * @property User $User
 */
class BriefLinkUser extends \CActiveRecord
{
    /**
     * @param string $className
     * @return BriefLinkUser
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'RaecBriefLinkUser';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [
            'Brief' => [self::BELONGS_TO, '\raec\models\Brief', 'Id'],
            'User' => [self::BELONGS_TO, '\company\models\User', 'Id'],
            'Role' => [self::BELONGS_TO, '\raec\models\BriefUserRole', 'Id']
        ];
    }

    /**
     * @param int $briefId
     * @param bool $useAnd
     * @return $this
     */
    public function byBriefId($briefId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."BriefId" = :BriefId';
        $criteria->params = array(':BriefId' => $briefId);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param int $userId
     * @param bool $useAnd
     * @return $this
     */
    public function byUserId($userId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."UserId" = :UserId';
        $criteria->params = array(':UserId' => $userId);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param int $roleId
     * @param bool $useAnd
     * @return $this
     */
    public function byRoleId($roleId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."RoleId" = :RoleId';
        $criteria->params = array(':RoleId' => $roleId);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }
} 