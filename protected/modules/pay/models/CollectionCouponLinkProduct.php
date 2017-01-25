<?php
namespace pay\models;

use application\components\ActiveRecord;

/**
 * @property integer $CollectionCouponId
 * @property integer $ProductId
 *
 * Описание вспомогательных методов
 * @method CollectionCouponLinkProduct   with($condition = '')
 * @method CollectionCouponLinkProduct   find($condition = '', $params = [])
 * @method CollectionCouponLinkProduct   findByPk($pk, $condition = '', $params = [])
 * @method CollectionCouponLinkProduct   findByAttributes($attributes, $condition = '', $params = [])
 * @method CollectionCouponLinkProduct[] findAll($condition = '', $params = [])
 * @method CollectionCouponLinkProduct[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method CollectionCouponLinkProduct byCollectionCouponId(int $id, bool $useAnd = true)
 * @method CollectionCouponLinkProduct byProductId(int $id, bool $useAnd = true)
 */
class CollectionCouponLinkProduct extends ActiveRecord
{
    /**
     * @param string $className
     * @return CollectionCouponLinkProduct
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'PayCollectionCouponLinkProduct';
    }

    public function primaryKey()
    {
        return ['CollectionCouponId', 'ProductId'];
    }
}