<?php
namespace ruvents\models;

use application\components\ActiveRecord;
use event\models\Event;
use event\models\Participant;
use event\models\UserData;
use user\models\User;

/**
 * @property integer $Id
 * @property string $EventId
 * @property integer $UserId
 * @property string $MarkId
 * @property string $CreationTime
 *
 * @property User $User
 * @property Event $Event
 * @property UserData $UserData
 * @property Participant[] $Participants
 *
 * Описание вспомогательных методов
 * @method Visit   with($condition = '')
 * @method Visit   find($condition = '', $params = [])
 * @method Visit   findByPk($pk, $condition = '', $params = [])
 * @method Visit   findByAttributes($attributes, $condition = '', $params = [])
 * @method Visit[] findAll($condition = '', $params = [])
 * @method Visit[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Visit byId(int $id, bool $useAnd = true)
 * @method Visit byEventId(int $id, bool $useAnd = true)
 * @method Visit byUserId(int $id, bool $useAnd = true)
 * @method Visit byMarkId(int $id, bool $useAnd = true)
 *
 * @method Visit orderByCreationTime(int $order)
 */
class Visit extends ActiveRecord implements \JsonSerializable
{
    public $CountForCriteria = 0;

    /**
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
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
    public function jsonSerialize()
    {
        return $this->getAttributes([
            'UserId',
            'MarkId',
            'CreationTime'
        ]);
    }
}
