<?php
namespace pay\models;

/**
 * @property int $Id
 * @property int $CouponId
 * @property int $UserId
 * @property string $CreationTime
 *
 * @property Coupon $Coupon
 * @property CouponActivationLinkOrderItem[] $OrderItemLinks
 * @property \user\models\User $User
 */
class CouponActivation extends \CActiveRecord
{

  /**
   * @static
   * @param string $className
   * @return CouponActivation
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'PayCouponActivation';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Coupon' => array(self::BELONGS_TO, '\pay\models\Coupon', 'CouponId'),
      'User' => array(self::BELONGS_TO, '\user\models\User', 'UserId'),
      'OrderItemLinks' => array(self::HAS_MANY, '\pay\models\CouponActivationLinkOrderItem', 'CouponActivationId')
    );
  }

  /**
   * @param int $userId
   * @param bool $useAnd
   * @return CouponActivation
   */
  public function byUserId($userId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."UserId" = :UserId';
    $criteria->params = array('UserId' => $userId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

    public function byCouponId($couponId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."CouponId" = :CouponId';
        $criteria->params = ['CouponId' => $couponId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
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
    $criteria->params = array(':EventId' => $eventId);
    $criteria->with = array('Coupon' => array('together' => true));
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  public function byEmptyLinkOrderItem($useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"OrderItemLinks"."CouponActivationId" IS NULL';
    $criteria->with = array('OrderItemLinks' => array('together' => true));
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  public function getDiscount(Product $product = null)
  {
    if ($product == null)
      return $this->Coupon->Discount;
    if (!$product->EnableCoupon)
      return 0;
    return $this->Coupon->getIsForProduct($product->Id) ? $this->Coupon->Discount : 0;
  }
}