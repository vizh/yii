<?php
namespace event\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $CatalogCompanyId
 * @property int $TypeId
 * @property int $Order
 *
 * Описание вспомогательных методов
 * @method EventPartner   with($condition = '')
 * @method EventPartner   find($condition = '', $params = [])
 * @method EventPartner   findByPk($pk, $condition = '', $params = [])
 * @method EventPartner   findByAttributes($attributes, $condition = '', $params = [])
 * @method EventPartner[] findAll($condition = '', $params = [])
 * @method EventPartner[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method EventPartner byId(int $id, bool $useAnd = true)
 * @method EventPartner byEventId(int $id, bool $useAnd = true)
 * @method EventPartner byCatalogCompanyId(int $id, bool $useAnd = true)
 * @method EventPartner byTypeId(int $id, bool $useAnd = true)
 */
class EventPartner extends ActiveRecord
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
        return 'EventPartner';
    }
}
