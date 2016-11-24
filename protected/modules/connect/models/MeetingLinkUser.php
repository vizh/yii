<?php

namespace connect\models;

use application\components\ActiveRecord;
use user\models\User;

/**
 * @property integer $Id
 * @property integer $MeetingId
 * @property integer $UserId
 * @property integer $Status
 * @property string $Response
 *
 * @property Meeting $Meeting
 * @property User $User
 *
 * @method MeetingLinkUser byMeetingId(int $id)
 * @method MeetingLinkUser byUserId(int $id)
 * @method MeetingLinkUser byStatus(int $id)
 *
 * @method MeetingLinkUser with($condition='')
 * @method MeetingLinkUser find($condition='',$params=array())
 * @method MeetingLinkUser findByPk($pk,$condition='',$params=array())
 * @method MeetingLinkUser findByAttributes($attributes,$condition='',$params=array())
 * @method MeetingLinkUser[] findAll($condition='',$params=array())
 * @method MeetingLinkUser[] findAllByAttributes($attributes,$condition='',$params=array())
 */
class MeetingLinkUser extends ActiveRecord
{
    const STATUS_SENT = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_DECLINED = 2;
    const STATUS_CANCELLED = 3;

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
}