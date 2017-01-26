<?php
namespace event\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Name
 * @property int $Order
 *
 * Описание вспомогательных методов
 * @method PartnerType   with($condition = '')
 * @method PartnerType   find($condition = '', $params = [])
 * @method PartnerType   findByPk($pk, $condition = '', $params = [])
 * @method PartnerType   findByAttributes($attributes, $condition = '', $params = [])
 * @method PartnerType[] findAll($condition = '', $params = [])
 * @method PartnerType[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method PartnerType byId(int $id, bool $useAnd = true)
 * @method PartnerType byEventId(int $id, bool $useAnd = true)
 */
class PartnerType extends ActiveRecord
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
        return 'EventPartnerType';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
        ];
    }
}