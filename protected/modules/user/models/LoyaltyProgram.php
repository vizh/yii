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
 * @property Event $Event
 * @property User $User
 *
 * Описание вспомогательных методов
 * @method LoyaltyProgram   with($condition = '')
 * @method LoyaltyProgram   find($condition = '', $params = [])
 * @method LoyaltyProgram   findByPk($pk, $condition = '', $params = [])
 * @method LoyaltyProgram   findByAttributes($attributes, $condition = '', $params = [])
 * @method LoyaltyProgram[] findAll($condition = '', $params = [])
 * @method LoyaltyProgram[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LoyaltyProgram byId(int $id, bool $useAnd = true)
 * @method LoyaltyProgram byUserId(int $id, bool $useAnd = true)
 * @method LoyaltyProgram byEventId(int $id, bool $useAnd = true)
 */
class LoyaltyProgram extends ActiveRecord
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
        return 'UserLoyaltyProgram';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId']
        ];
    }
}