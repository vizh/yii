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
 * @method EventPartnerType   with($condition = '')
 * @method EventPartnerType   find($condition = '', $params = [])
 * @method EventPartnerType   findByPk($pk, $condition = '', $params = [])
 * @method EventPartnerType   findByAttributes($attributes, $condition = '', $params = [])
 * @method EventPartnerType[] findAll($condition = '', $params = [])
 * @method EventPartnerType[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method EventPartnerType byId(int $id, bool $useAnd = true)
 * @method EventPartnerType byEventId(int $id, bool $useAnd = true)
 */
class EventPartnerType extends ActiveRecord
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
}
