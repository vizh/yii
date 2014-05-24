<?php
namespace ruvents\models;

/**
 * Class Account
 * @package ruvents\models
 *
 * @property int $Id
 * @property int $EventId
 * @property string $Hash
 * @property string $Role
 *
 * @property \event\models\Event $Event
 */
class Account extends \CActiveRecord
{
    /**
     * @static
     * @param string $className
     * @return Account
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'RuventsAccount';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
        ];
    }

    /**
     * @param string $hash
     * @param bool $useAnd
     * @return Account
     */
    public function byHash($hash, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."Hash" = :Hash';
        $criteria->params = ['Hash' => $hash];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param int $eventId
     * @param bool $useAnd
     * @return Account
     */
    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."EventId" = :EventId';
        $criteria->params = ['EventId' => $eventId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param string $role
     * @param bool $useAnd
     * @return $this
     */
    public function byRole($role, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."Role" = :Role';
        $criteria->params = ['Role' => $role];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }
}