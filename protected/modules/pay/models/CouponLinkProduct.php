<?php
namespace pay\models;

use application\components\ActiveRecord;

/**
 * @property integer $CouponId
 * @property integer $ProductId
 *
 * Описание вспомогательных методов
 * @method CouponLinkProduct   with($condition = '')
 * @method CouponLinkProduct   find($condition = '', $params = [])
 * @method CouponLinkProduct   findByPk($pk, $condition = '', $params = [])
 * @method CouponLinkProduct   findByAttributes($attributes, $condition = '', $params = [])
 * @method CouponLinkProduct[] findAll($condition = '', $params = [])
 * @method CouponLinkProduct[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method CouponLinkProduct byCouponId(int $id, bool $useAnd = true)
 * @method CouponLinkProduct byProductId(int $id, bool $useAnd = true)
 */
class CouponLinkProduct extends ActiveRecord
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
        return 'PayCouponLinkProduct';
    }

    public function primaryKey()
    {
        return ['CouponId', 'ProductId'];
    }
}