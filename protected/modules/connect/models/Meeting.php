<?php

namespace connect\models;

use application\components\ActiveRecord;
use user\models\User;

/**
 * @property integer $Id
 * @property integer $PlaceId
 * @property integer $CreatorId
 * @property integer $UserId
 * @property string $Date
 * @property integer $Status
 *
 * @property Place[] $Places
 * @property User $Creator
 * @property User $User
 */
class Meeting extends ActiveRecord
{
    const STATUS_SENT = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_DECLINED = 2;

    public function tableName()
    {
        return 'ConnectMeeting';
    }

    public function relations()
    {
        return [
            'Place' => [self::BELONGS_TO, '\connect\models\Place', 'PlaceId'],
            'Creator' => [self::BELONGS_TO, '\user\models\User', 'CreatorId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
        ];
    }

    public function byCreator($user, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."CreatorId" = :CreatorId';
        $criteria->params = array('CreatorId' => $user->Id);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    public function byUser($user, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."UserId" = :UserId';
        $criteria->params = array('UserId' => $user->Id);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }
}