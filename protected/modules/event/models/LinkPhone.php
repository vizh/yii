<?php
namespace event\models;

use application\components\ActiveRecord;
use contact\models\Phone;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $PhoneId
 *
 * @property Event $Event
 * @property Phone $Phone
 *
 * Описание вспомогательных методов
 * @method LinkPhone   with($condition = '')
 * @method LinkPhone   find($condition = '', $params = [])
 * @method LinkPhone   findByPk($pk, $condition = '', $params = [])
 * @method LinkPhone   findByAttributes($attributes, $condition = '', $params = [])
 * @method LinkPhone[] findAll($condition = '', $params = [])
 * @method LinkPhone[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LinkPhone byId(int $id, bool $useAnd = true)
 * @method LinkPhone byEventId(int $id, bool $useAnd = true)
 * @method LinkPhone byPhoneId(int $id, bool $useAnd = true)
 */
class LinkPhone extends ActiveRecord
{
    /**
     * @param string $className
     * @return LinkPhone
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventLinkPhone';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
            'Phone' => [self::BELONGS_TO, '\contact\models\Phone', 'PhoneId'],
        ];
    }
}
