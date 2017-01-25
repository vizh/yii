<?php
namespace pay\models;

use application\components\ActiveRecord;
use user\models\User;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $CouponId
 * @property string $CreationTime
 *
 * @property User $User
 * @property Coupon $Coupon
 * @property CouponActivationLinkOrderItem[] $OrderItemLinks
 *
 * Описание вспомогательных методов
 * @method CouponActivation   with($condition = '')
 * @method CouponActivation   find($condition = '', $params = [])
 * @method CouponActivation   findByPk($pk, $condition = '', $params = [])
 * @method CouponActivation   findByAttributes($attributes, $condition = '', $params = [])
 * @method CouponActivation[] findAll($condition = '', $params = [])
 * @method CouponActivation[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method CouponActivation byId(int $id, bool $useAnd = true)
 * @method CouponActivation byUserId(int $id, bool $useAnd = true)
 * @method CouponActivation byCouponId(int $id, bool $useAnd = true)
 */
class CouponActivation extends ActiveRecord
{

    /**
     * @param string $className
     * @return CouponActivation
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'PayCouponActivation';
    }

    public function relations()
    {
        return [
            'Coupon' => [self::BELONGS_TO, '\pay\models\Coupon', 'CouponId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
            'OrderItemLinks' => [self::HAS_MANY, '\pay\models\CouponActivationLinkOrderItem', 'CouponActivationId']
        ];
    }

    /**
     * @param int $eventId
     * @param bool $useAnd
     * @return CouponActivation
     */
    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"Coupon"."EventId" = :EventId';
        $criteria->params = [':EventId' => $eventId];
        $criteria->with = ['Coupon' => ['together' => true]];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    public function byEmptyLinkOrderItem($useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"OrderItemLinks"."CouponActivationId" IS NULL';
        $criteria->with = ['OrderItemLinks' => ['together' => true]];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * Возвращает размер скидки
     *
     * @param Product|null $product
     * @return int|string
     */
    public function getDiscount(Product $product = null)
    {
        if ($product == null) {
            return $this->Coupon->getManager()->getDiscountString();
        }

        if (!$product->EnableCoupon) {
            return 0;
        }

        $price = $product->getPrice();

        return $this->Coupon->getIsForProduct($product->Id) ? $price - $this->Coupon->getManager()->calcDiscountPrice($price) : 0;
    }
}