<?php
namespace event\models;

use application\models\translation\ActiveRecord;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Name
 * @property string $Value
 * @property int $Order
 *
 * @property Event $Event
 *
 * Описание вспомогательных методов
 * @method Attribute   with($condition = '')
 * @method Attribute   find($condition = '', $params = [])
 * @method Attribute   findByPk($pk, $condition = '', $params = [])
 * @method Attribute   findByAttributes($attributes, $condition = '', $params = [])
 * @method Attribute[] findAll($condition = '', $params = [])
 * @method Attribute[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Attribute byId(int $id, bool $useAnd = true)
 * @method Attribute byEventId(int $id, bool $useAnd = true)
 * @method Attribute byName(int $id, bool $useAnd = true)
 */
class Attribute extends ActiveRecord
{
    /**
     * @param string $className
     * @return Attribute
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventAttribute';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
        ];
    }

    /**
     *
     * @return string[]
     */
    public function getTranslationFields()
    {
        return ['Value'];
    }
}
