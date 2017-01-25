<?php
namespace user\models;

use application\components\ActiveRecord;
use event\models\Event;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $EventId
 * @property string $CreationTime
 *
 * @property User $User
 * @property Event $Event
 *
 * Описание вспомогательных методов
 * @method UnsubscribeEventMail   with($condition = '')
 * @method UnsubscribeEventMail   find($condition = '', $params = [])
 * @method UnsubscribeEventMail   findByPk($pk, $condition = '', $params = [])
 * @method UnsubscribeEventMail   findByAttributes($attributes, $condition = '', $params = [])
 * @method UnsubscribeEventMail[] findAll($condition = '', $params = [])
 * @method UnsubscribeEventMail[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method UnsubscribeEventMail byId(int $id, bool $useAnd = true)
 * @method UnsubscribeEventMail byUserId(int $id, bool $useAnd = true)
 * @method UnsubscribeEventMail byEventId(int $id, bool $useAnd = true)
 */
class UnsubscribeEventMail extends ActiveRecord
{
    /**
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'UserUnsubscribeEventMail';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId']
        ];
    }
}
