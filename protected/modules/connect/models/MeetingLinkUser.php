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
 * Описание вспомогательных методов
 * @method MeetingLinkUser   with($condition = '')
 * @method MeetingLinkUser   find($condition = '', $params = [])
 * @method MeetingLinkUser   findByPk($pk, $condition = '', $params = [])
 * @method MeetingLinkUser   findByAttributes($attributes, $condition = '', $params = [])
 * @method MeetingLinkUser[] findAll($condition = '', $params = [])
 * @method MeetingLinkUser[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method MeetingLinkUser byId(int $id, bool $useAnd = true)
 * @method MeetingLinkUser byMeetingId(int $id, bool $useAnd = true)
 * @method MeetingLinkUser byUserId(int $id, bool $useAnd = true)
 * @method MeetingLinkUser byStatus(int $status, bool $useAnd = true)
 */
class MeetingLinkUser extends ActiveRecord
{
    const STATUS_SENT = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_DECLINED = 2;
    const STATUS_CANCELLED = 3;

    /**
     * @param string $className
     * @return MeetingLinkUser
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

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