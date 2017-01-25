<?php
namespace ruvents\models;

use application\components\ActiveRecord;
use event\models\Event;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Hash
 * @property string $Role
 *
 * @property Event $Event
 *
 * Описание вспомогательных методов
 * @method Account   with($condition = '')
 * @method Account   find($condition = '', $params = [])
 * @method Account   findByPk($pk, $condition = '', $params = [])
 * @method Account   findByAttributes($attributes, $condition = '', $params = [])
 * @method Account[] findAll($condition = '', $params = [])
 * @method Account[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Account byId(int $id, bool $useAnd = true)
 * @method Account byEventId(int $id, bool $useAnd = true)
 * @method Account byHash(string $hash, bool $useAnd = true)
 * @method Account byRole(string $role, bool $useAnd = true)
 */
class Account extends ActiveRecord
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
        return 'RuventsAccount';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
        ];
    }
}