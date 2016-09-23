<?php
namespace ruvents\models;

use application\components\ActiveRecord;
use event\models\Event;
use event\models\Participant;
use event\models\UserData;
use user\models\User;

/**
 * This is the model class for table "RuventsVisit".
 *
 * The followings are the available columns in table 'RuventsVisit':
 *
 * @property integer $Id
 * @property string $EventId
 * @property integer $UserId RunetId of the user
 * @property string $MarkId
 * @property string $CreationTime
 *
 * The followings are the available model relations:
 * @property User $User
 * @property Event $Event
 * @property UserData $UserData
 * @property Participant[] $Participants
 *
 * @method Visit[] findAll($condition = '', $params = [])
 * @method Visit byEventId(int $id)
 * @method Visit byUserId(int $id)
 */
class Visit extends ActiveRecord implements \JsonSerializable
{
    public $CountForCriteria = 0;

    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className active record class name.
     * @return Visit the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'RuventsVisit';
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, 'user\models\User', 'UserId'],
            'Event' => [self::BELONGS_TO, 'event\models\Event', 'EventId'],
            'UserData' => [self::HAS_ONE, 'event\models\UserData', ['EventId' => 'EventId', 'UserId' => 'UserId']],
            'Participants' => [
                self::HAS_MANY,
                'event\models\Participant',
                ['EventId' => 'EventId', 'UserId' => 'UserId']
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    function jsonSerialize()
    {
        return $this->getAttributes([
            'UserId',
            'MarkId',
            'CreationTime'
        ]);
    }
}
