<?php
namespace event\models;

use application\components\ActiveRecord;
use contact\models\Email;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $EmailId
 *
 * @property Event $Event
 * @property Email $Email
 *
 * Описание вспомогательных методов
 * @method LinkEmail   with($condition = '')
 * @method LinkEmail   find($condition = '', $params = [])
 * @method LinkEmail   findByPk($pk, $condition = '', $params = [])
 * @method LinkEmail   findByAttributes($attributes, $condition = '', $params = [])
 * @method LinkEmail[] findAll($condition = '', $params = [])
 * @method LinkEmail[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LinkEmail byId(int $id, bool $useAnd = true)
 * @method LinkEmail byEventId(int $id, bool $useAnd = true)
 * @method LinkEmail byEmailId(int $id, bool $useAnd = true)
 */
class LinkEmail extends ActiveRecord
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
        return 'EventLinkEmail';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
            'Email' => [self::BELONGS_TO, '\contact\models\Email', 'EmailId'],
        ];
    }
}
