<?php
namespace pay\models;

/**
 * @property int $CouponActivatedId
 * @property int $CouponId
 * @property int $UserId
 * @property string $CreationTime
 *
 * @property Coupon $Coupon
 * @property OrderItem[] $OrderItems
 */
class CouponActivated extends \CActiveRecord
{
  public static $TableName = 'Mod_PayCouponActivated';

  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return self::$TableName;
  }

  public function primaryKey()
  {
    return 'CouponActivatedId';
  }

  public function relations()
  {
    return array(
      'Coupon' => array(self::BELONGS_TO, 'Coupon', 'CouponId'),
      'User' => array(self::BELONGS_TO, 'User', 'UserId'),
      'OrderItems' => array(self::MANY_MANY, 'OrderItem', 'Mod_PayCouponActivatedOrderItemLink(CouponActivatedId, OrderItemId)')
    );
  }

  /**
   * @static
   * @param int $userId
   * @param int $eventId
   * @return CouponActivated
   */
  public static function GetByEvent($userId, $eventId)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.UserId = :UserId AND Coupon.EventId = :EventId';
    $criteria->params = array(':UserId' => $userId,':EventId' => $eventId);
    $criteria->order = 't.CreationTime DESC';

    return CouponActivated::model()->with('Coupon')->find($criteria);
  }

  /**
   * @static
   * @param array() $usersId
   * @param int $eventId
   * @return CouponActivated[]
   */
  public static function GetListByEvent($usersId, $eventId)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 'Coupon.EventId = :EventId';
    $criteria->params = array(':EventId' => $eventId);
    $criteria->addInCondition('t.UserId', $usersId);
    $criteria->order = 't.CreationTime DESC';

    return CouponActivated::model()->with('Coupon')->findAll($criteria);
  }

  /**
   * @param OrderItem $orderItem
   * @return bool
   */
  public function CheckOrderItem($orderItem)
  {
    if (empty($this->OrderItems))
    {
      return true;
    }

    foreach ($this->OrderItems as $item)
    {
      if ($orderItem->OrderItemId === $item->OrderItemId)
      {
        return true;
      }
    }
    return false;
  }
}