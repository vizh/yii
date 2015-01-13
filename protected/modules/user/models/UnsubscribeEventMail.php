<?php
namespace user\models;
use event\models\Event;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $EventId
 * @property string $CreationTime
 *
 * @property User $User
 * @property Event $Event
 */
class UnsubscribeEventMail extends \CActiveRecord
{
    /**
     * @param string $className
     * @return UnsubscribeEventMail
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'UserUnsubscribeEventMail';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId']
        ];
    }

    /**
     * @param int $eventId
     * @param bool $useAnd
     * @return $this
     */
    public function byUserId($userId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."UserId" = :UserId';
        $criteria->params = [':UserId' => $userId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param int $eventId
     * @param bool $useAnd
     * @return $this
     */
    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."EventId" = :EventId';
        $criteria->params = [':EventId' => $eventId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }
}
