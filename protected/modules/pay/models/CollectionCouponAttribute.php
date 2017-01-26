<?php
namespace pay\models;
use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $CollectionCouponId
 * @property string $Name
 * @property string $Value
 *
 * Описание вспомогательных методов
 * @method CollectionCouponAttribute   with($condition = '')
 * @method CollectionCouponAttribute   find($condition = '', $params = [])
 * @method CollectionCouponAttribute   findByPk($pk, $condition = '', $params = [])
 * @method CollectionCouponAttribute   findByAttributes($attributes, $condition = '', $params = [])
 * @method CollectionCouponAttribute[] findAll($condition = '', $params = [])
 * @method CollectionCouponAttribute[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method CollectionCouponAttribute byId(int $id, bool $useAnd = true)
 * @method CollectionCouponAttribute byCollectionCouponId(int $id, bool $useAnd = true)
 * @method CollectionCouponAttribute byName(int $id, bool $useAnd = true)
 */
class CollectionCouponAttribute extends ActiveRecord
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
        return 'PayCollectionCouponAttribute';
    }
}