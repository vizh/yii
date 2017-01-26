<?php
namespace pay\models;

use application\components\ActiveRecord;

/**
 * @property int $LinkId
 * @property int $CouponActivationId
 * @property int $OrderItemId
 *
 * @property CouponActivation $CouponActivation
 * @property OrderItem $OrderItem
 *
 * Описание вспомогательных методов
 * @method CouponActivationLinkOrderItem   with($condition = '')
 * @method CouponActivationLinkOrderItem   find($condition = '', $params = [])
 * @method CouponActivationLinkOrderItem   findByPk($pk, $condition = '', $params = [])
 * @method CouponActivationLinkOrderItem   findByAttributes($attributes, $condition = '', $params = [])
 * @method CouponActivationLinkOrderItem[] findAll($condition = '', $params = [])
 * @method CouponActivationLinkOrderItem[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method CouponActivationLinkOrderItem byId(int $id, bool $useAnd = true)
 * @method CouponActivationLinkOrderItem byLinkId(int $id, bool $useAnd = true)
 * @method CouponActivationLinkOrderItem byCouponActivationId(int $id, bool $useAnd = true)
 * @method CouponActivationLinkOrderItem byOrderItemId(int $id, bool $useAnd = true)
 */
class CouponActivationLinkOrderItem extends ActiveRecord
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
        return 'PayCouponActivationLinkOrderItem';
    }

    public function relations()
    {
        return [
            'CouponActivation' => [self::BELONGS_TO, '\pay\models\CouponActivation', 'CouponActivationId'],
            'OrderItem' => [self::BELONGS_TO, '\pay\models\OrderItem', 'OrderItemId']
        ];
    }
}