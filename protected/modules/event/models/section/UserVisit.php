<?php
namespace event\models\section;
use application\components\ActiveRecord;
use user\models\User;

/**
 * @property int $Id
 * @property int $HallId
 * @property int $UserId
 * @property string VisitTime
 * @property string CreationTime
 * @property int $OperatorId
 *
 * @property Hall $Hall
 * @property User $User
 *
 * @method UserVisit byHallId(integer $hallId)
 */
class UserVisit extends ActiveRecord
{
    /**
     * @param string $className
     * @return UserVisit
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventSectionUserVisit';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [
            'Hall' => [self::BELONGS_TO, 'event\models\section\Hall', 'HallId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId']
        ];
    }

    /**
     * @param int $eventId
     * @param bool $useAnd
     * @return $this
     */
    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->with = ['Hall'];
        $criteria->condition = '"Hall"."EventId" = :EventId';
        $criteria->params = ['EventId' => $eventId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }
}