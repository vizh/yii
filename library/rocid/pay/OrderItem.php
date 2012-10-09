<?php

/**
 * @property int $OrderItemId
 * @property int $ProductId
 * @property int $PayerId
 * @property int $OwnerId
 * @property int $CouponActivatedId
 * @property string $Booked
 * @property int $Paid
 * @property string $PaidTime
 * @property string $CreationTime
 * @property int $Deleted
 *
 * @property Product $Product
 * @property User $Payer
 * @property User $Owner
 * @property Order[] $Orders
 * @property OrderItemParam[] $Params
 */
class OrderItem extends CActiveRecord
{
  public static $TableName = 'Mod_PayOrderItem';

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
    return 'OrderItemId';
  }

  public function relations()
  {
    return array(
      'Product' => array(self::BELONGS_TO, 'Product', 'ProductId'),
      'Payer' => array(self::BELONGS_TO, 'User', 'PayerId'),
      'Owner' => array(self::BELONGS_TO, 'User', 'OwnerId'),
      'Orders' => array(self::MANY_MANY, 'Order', 'Mod_PayOrderItemLink(OrderItemId, OrderId)'),

      'Params' => array(self::HAS_MANY, 'OrderItemParam', 'OrderItemId'),
    );
  }

  /**
   * @var CouponActivated
   */
  private $couponActivated = null;
  /** @var bool */
  private $couponTrySet = false;
  /**
   * @return CouponActivated
   */
  public function GetCouponActivated()
  {
    if ($this->couponActivated === null && !$this->couponTrySet)
    {
      $this->couponTrySet = true;
      $eventId = $this->Product->EventId;
      $couponActivated = CouponActivated::GetByEvent($this->OwnerId, $eventId);

      $existDiscount = $couponActivated !== null && !empty($couponActivated->Coupon);
      $canApplyDiscount = $existDiscount && $couponActivated->CheckOrderItem($this);
      $rightTime = $existDiscount && ($this->PaidTime === null || $this->PaidTime >= $couponActivated->CreationTime);

      if ($canApplyDiscount && $rightTime && $this->Product->EnableCoupon == 1)
      {
        $this->couponActivated = $couponActivated;
      }
      else
      {
        $this->couponActivated = null;
      }
    }
    return $this->couponActivated;
  }

  /**
   * Обдумать необходимость этого метода
   * @param CouponActivated $couponActivated
   */
//  public function SetCouponActivated($couponActivated)
//  {
//    $this->couponActivated = $couponActivated;
//  }

  /**
   * @static
   * @param int $orderItemId
   * @return OrderItem
   */
  public static function GetById($orderItemId)
  {
    $model = OrderItem::model()->with(array('Product', 'Product.Attributes', 'Owner'));
    return $model->findByPk($orderItemId);
  }

  /**
   * @static
   * @param int $payerId
   * @param int $eventId
   * @return OrderItem[]
   */
  public static function GetByEventId($payerId, $eventId)
  {
    $criteria = new CDbCriteria();
    $criteria->distinct = true;
    $criteria->with = array('Orders' => array('select' => false), 'Orders.OrderJuridical' => array('select' => false));
    $criteria->condition = 't.PayerId = :PayerId AND t.Paid = 0 AND OrderJuridical.Deleted = 0';
    $criteria->params = array(':PayerId' => $payerId);
    $criteria->select = array('t.OrderItemId');

    $itemRecords = OrderItem::model()->findAll($criteria);
    $items = array();
    foreach ($itemRecords as $item)
    {
      $items[] = $item->OrderItemId;
    }

    $criteria = new CDbCriteria();
    $criteria->with = array('Product', 'Product.Attributes', 'Owner');
    $criteria->condition = 'Product.EventId = :EventId AND (t.Booked IS NULL OR t.Booked > :Booked OR t.Paid = :Paid) AND t.Deleted = :Deleted AND t.PayerId = :PayerId';
    $criteria->params = array(':PayerId' => $payerId, ':EventId' => $eventId, ':Booked' => date('Y-m-d H:i:s'),
    ':Paid' => 1, ':Deleted' => 0);
    $criteria->addNotInCondition('t.OrderItemId', $items);

    return OrderItem::model()->findAll($criteria);
  }

  /**
   * @static
   * @param int $ownerId
   * @param int $eventId
   * @return OrderItem[]
   */
  public static function GetByOwnerAndEventId($ownerId, $eventId)
  {
    $criteria = new CDbCriteria();
    $criteria->with = array('Product', 'Product.Attributes', 'Owner');
    $criteria->condition = 'Product.EventId = :EventId AND (t.Booked IS NULL OR t.Booked > :Booked OR t.Paid = :Paid) AND t.Deleted = :Deleted AND t.OwnerId = :OwnerId';
    $criteria->params = array(':OwnerId' => $ownerId, ':EventId' => $eventId, ':Booked' => date('Y-m-d H:i:s'),
      ':Paid' => 1, ':Deleted' => 0);

    return OrderItem::model()->findAll($criteria);
  }

  public static function GetAllByEventId($eventId, $payerId, $ownerId = null)
  {
    $criteria = new CDbCriteria();
    $criteria->with = array('Product', 'Product.Attributes', 'Owner');
    $criteria->condition = 'Product.EventId = :EventId AND (t.Booked IS NULL OR t.Booked > :Booked OR t.Paid = :Paid) AND t.Deleted = :Deleted AND t.PayerId = :PayerId';
    $criteria->params = array(':PayerId' => $payerId, ':EventId' => $eventId, ':Booked' => date('Y-m-d H:i:s'),
      ':Paid' => 1, ':Deleted' => 0);

    if (!empty($ownerId))
    {
      $criteria->addCondition('t.OwnerId = :OwnerId');
      $criteria->params[':OwnerId'] = $ownerId;
    }

    return OrderItem::model()->findAll($criteria);
  }

  /**
   * @static
   * @param int $productId
   * @param int $payerId
   * @param int $ownerId
   * @return OrderItem|null
   */
  public static function GetByAll($productId, $payerId, $ownerId)
  {
    $criteria = new CDbCriteria();
    $criteria->condition = 't.ProductId = :ProductId AND t.PayerId = :PayerId AND t.OwnerId = :OwnerId AND t.Deleted = :Deleted';
    $criteria->params = array(':ProductId'=> $productId, ':PayerId' => $payerId, ':OwnerId' => $ownerId, ':Deleted' => 0);
    $criteria->order = 't.OrderItemId DESC';

    return OrderItem::model()->find($criteria);
  }

  /**
   * @static
   * @return int
   */
  public static function ClearBooked()
  {
    $db = Registry::GetDb();
    return $db->createCommand()->update('Mod_PayOrderItem', array('Deleted' => 1),
      'Booked IS NOT NULL AND Booked < :Booked AND Paid != :Paid AND Deleted != :Deleted',
      array(':Booked' => date('Y-m-d H:i:s'), ':Paid' => 1, ':Deleted' => 1));
  }

  /**
   * @return int
   */
  public function Price()
  {
    return $this->Product->ProductManager()->GetPrice($this);
  }

  /**
   * Итоговое значение цены товара, с учетом скидки, если она есть
   * @return float|null
   */
  public function PriceDiscount()
  {
    $couponActivated = $this->GetCouponActivated();
    $price = $this->Price();
    if ($price === null)
    {
      return null;
    }

    if ($couponActivated !== null)
    {
      return $price * (1 - $couponActivated->Coupon->Discount);
    }
    return $price;
  }

  public function AddParam($name, $value)
  {
    $param = new OrderItemParam();
    $param->OrderItemId = $this->OrderItemId;
    $param->Name = $name;
    $param->Value = $value;
    $param->save();

    return $param;
  }

  private $paramsCache = null;
    /**
     * @param $name
     * @return ProductAttribute|null
     */
  public function GetParam($name)
  {
    if ($this->paramsCache == null)
    {
      $this->paramsCache = array();
      foreach ($this->Params as $param)
      {
        $this->paramsCache[$param->Name] = $param;
      }
    }
    return isset($this->paramsCache[$name]) ? $this->paramsCache[$name] : null;
  }

}