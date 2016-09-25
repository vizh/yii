<?php

namespace connect\models;

use application\components\ActiveRecord;

/**
 * @property integer $Id
 * @property integer $MeetingId
 * @property integer $UserId
 * @property integer $Status
 * @property string $Response
 */
class MeetingLinkUser extends ActiveRecord
{
    const STATUS_SENT = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_DECLINED = 2;

    public function tableName()
    {
        return 'ConnectMeetingLinkUser';
    }

    public function relations()
    {
        return [
            'Meeting' => [self::BELONGS_TO, '\connect\models\Meeting', 'MeetingId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
        ];
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