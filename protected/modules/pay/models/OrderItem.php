<?php
namespace pay\models;

/**
 * @property int $OrderItemId
 * @property int $ProductId
 * @property int $PayerId
 * @property int $OwnerId
 * @property int $RedirectId
 * @property int $CouponActivatedId
 * @property string $Booked
 * @property int $Paid
 * @property string $PaidTime
 * @property string $CreationTime
 * @property int $Deleted
 *
 * @property Product $Product
 * @property \user\models\User $Payer
 * @property \user\models\User $Owner
 * @property \user\models\User $RedirectUser
 * @property Order $Orders
 * @property OrderItemParam[] $Params
 */
class OrderItem extends \CActiveRecord
{
  public static $TableName = 'Mod_PayOrderItem';

  /**
   * @static
   * @param string $className
   * @return OrderItem
   */
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
      'Product' => array(self::BELONGS_TO, '\pay\models\Product', 'ProductId'),
      'Payer' => array(self::BELONGS_TO, '\user\models\User', 'PayerId'),
      'Owner' => array(self::BELONGS_TO, '\user\models\User', 'OwnerId'),
      'RedirectUser' => array(self::BELONGS_TO, '\user\models\User', 'RedirectId'),
      'Orders' => array(self::MANY_MANY, '\pay\models\Order', 'Mod_PayOrderItemLink(OrderItemId, OrderId)'),

      'Params' => array(self::HAS_MANY, '\pay\models\OrderItemParam', 'OrderItemId'),
    );
  }


  /**
   * @param int $userId
   * @param bool $useAnd
   * @return OrderItem
   */
  public function byPayerId($userId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.PayerId = :PayerId';
    $criteria->params = array(':PayerId' => $userId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param int $userId
   * @param bool $useAnd
   * @return OrderItem
   */
  public function byOwnerId($userId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.OwnerId = :OwnerId';
    $criteria->params = array(':OwnerId' => $userId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param int|null $userId
   * @param bool $useAnd
   * @return OrderItem
   */
  public function byRedirectId($userId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    if ($userId !== null)
    {
      $criteria->condition = 't.RedirectId = :RedirectId';
      $criteria->params = array(':RedirectId' => $userId);
    }
    else
    {
      $criteria->condition = 't.RedirectId IS NULL';
    }
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param int $eventId
   * @param bool $useAnd
   * @return OrderItem
   */
  public function byEventId($eventId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 'Product.EventId = :EventId';
    $criteria->params = array(':EventId' => $eventId);
    $criteria->with = array('Product');
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param int $paid
   * @param bool $useAnd
   * @return OrderItem
   */
  public function byPaid($paid, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.Paid = :Paid';
    $criteria->params = array(':Paid' => $paid);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
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
      $couponActivatedList = CouponActivated::GetByEvent($this->OwnerId, $eventId);

      /** @var $couponActivated CouponActivated */
      $couponActivated = null;
      foreach ($couponActivatedList as $item)
      {
        if (!empty($item->Coupon->ProductId))
        {
          if ($item->Coupon->ProductId == $this->ProductId)
          {
            $couponActivated = $item;
            break;
          }
        }
        else
        {
          $couponActivated = $item;
        }
      }


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
    $criteria = new \CDbCriteria();
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

    $criteria = new \CDbCriteria();
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
    $criteria = new \CDbCriteria();
    $criteria->with = array('Product', 'Product.Attributes', 'Owner');
    $criteria->condition = 'Product.EventId = :EventId AND (t.Booked IS NULL OR t.Booked > :Booked OR t.Paid = :Paid) AND t.Deleted = :Deleted AND t.OwnerId = :OwnerId';
    $criteria->params = array(':OwnerId' => $ownerId, ':EventId' => $eventId, ':Booked' => date('Y-m-d H:i:s'),
      ':Paid' => 1, ':Deleted' => 0);

    return OrderItem::model()->findAll($criteria);
  }

  public static function GetAllByEventId($eventId, $payerId, $ownerId = null)
  {
    $criteria = new \CDbCriteria();
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
    $criteria = new \CDbCriteria();
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
    $db = \Yii::app()->getDb();
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

  private $paramValuesCache = null;
  /**
   * @return array
   */
  public function GetParamValues()
  {
    if ($this->paramValuesCache == null)
    {
      $this->paramValuesCache = array();
      foreach ($this->Params as $param)
      {
        $this->paramValuesCache[] = $param->Value;
      }
    }
    return $this->paramValuesCache;
  }


  /**
   * @param \user\models\User $toUser
   * @return bool
   */
  public function setRedirectUser(\user\models\User $toUser)
  {
    $fromUser = empty($this->RedirectUser) ? $this->Owner : $this->RedirectUser;
    if ($this->Product->ProductManager()->RedirectProduct($fromUser, $toUser))
    {
      $this->RedirectId = $toUser->UserId;
      $this->save();
      return true;
    }

    return false;
  }
}
