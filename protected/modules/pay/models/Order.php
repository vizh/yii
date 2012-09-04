<?php
namespace pay\models;

/**
 * @property int $OrderId
 * @property int $PayerId
 * @property int $EventId
 * @property string $CreationTime
 *
 * @property OrderItem[] $Items
 * @property OrderJuridical $OrderJuridical
 * @property \user\models\User $Payer
 */
class Order extends \CActiveRecord
{
  const BookDayCount = 5;

  public static $TableName = 'Mod_PayOrder';

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
    return 'OrderId';
  }

  public function relations()
  {
    return array(
      'Items' => array(self::MANY_MANY, '\pay\models\OrderItem', 'Mod_PayOrderItemLink(OrderId, OrderItemId)'),
      'OrderJuridical' => array(self::HAS_ONE, '\pay\models\OrderJuridical', 'OrderId'),
      'Payer' => array(self::BELONGS_TO, '\user\models\User', 'PayerId')
    );
  }

  /**
   * @static
   * @param int $id
   * @return Order
   */
  public static function GetById($id)
  {
    return Order::model()->with('Items', 'Items.Product')->findByPk($id);
  }


  /**
   * @static
   * @param int $rocId
   * @return string
   */
  public static function GenerateOrderId($rocId)
  {
    $time = time();
    return $rocId . '-' . $time;
  }

  public static function SetPaidByOrderId($orderId)
  {
    $time = date('Y-m-d H:i:s');
    $order = self::GetById($orderId);
    foreach ($order->Items as $item)
    {
      $item->Paid = 1;
      if ($item->PaidTime == null)
      {
        $item->PaidTime = $time;
      }
      $item->save();
    }
  }

  /**
   * @param OrderItem $orderItem
   * @return void
   */
  public function AddOrderItem($orderItem)
  {
    \Yii::app()->db->createCommand()->
        insert('Mod_PayOrderItemLink', array('OrderId' => $this->OrderId, 'OrderItemId' => $orderItem->OrderItemId));
  }

  /**
   * Возвращает массив с полями OrderId и Total (сумма заказа)
   * @static
   * @param \user\models\User $user
   * @param int $eventId
   * @param array $juridicalData
   * @return array
   */
  public static function CreateOrder($user, $eventId, $juridicalData = array())
  {
    $orderItems = OrderItem::GetByEventId($user->UserId, $eventId);
    $total = 0;

    $order = new Order();
    $order->PayerId = $user->UserId;
    $order->EventId = $eventId;
    $order->CreationTime = date('Y-m-d H:i:s');
    $order->save();

    if (!empty($juridicalData))
    {
      $orderJuridical= new OrderJuridical();
      $orderJuridical->OrderId = $order->OrderId;
      $orderJuridical->Name = $juridicalData['Name'];
      $orderJuridical->Address = $juridicalData['Address'];
      $orderJuridical->INN = $juridicalData['INN'];
      $orderJuridical->KPP = $juridicalData['KPP'];
      $orderJuridical->Phone = $juridicalData['Phone'];
      $orderJuridical->Fax = $juridicalData['Fax'];
      $orderJuridical->PostAddress = $juridicalData['PostAddress'];
      $orderJuridical->save();
    }

    foreach ($orderItems as $item)
    {
      if ($item->Paid == 0)
      {
        $total += $item->PriceDiscount();
        $order->AddOrderItem($item);
        if (!empty($juridicalData))
        {
          if ($item->Booked != null)
          {
            $item->Booked = self::GetBookEnd($item->CreationTime);
          }
          $item->PaidTime = $order->CreationTime;
          $item->save();
        }
      }
    }

    return array('OrderId' => $order->OrderId, 'Total' => $total);
  }

  /**
   * @static
   * @param string $start
   * @return string format Y-m-d H:i:s
   */
  private static function GetBookEnd($start)
  {
    $timestamp = strtotime($start);

    $days = 0;
    while ($days < self::BookDayCount)
    {
      $timestamp += 60*60*24;
      $dayOfWeek = intval(date('N', $timestamp));
      if ($dayOfWeek == 6 || $dayOfWeek == 7)
      {
        continue;
      }
      $days++;
    }

    return date('Y-m-d 22:59:59', $timestamp);
  }

  /**
   * @static
   * @param int $payerId
   * @param int $eventId
   * @return Order[]
   */
  public static function GetOrdersWithJuridical($payerId, $eventId)
  {
    $model = Order::model()->with('OrderJuridical', 'Items', 'Items.Product');

    $criteria = new \CDbCriteria();
    $criteria->condition = 't.PayerId = :PayerId AND t.EventId = :EventId AND OrderJuridical.Deleted = 0';
    $criteria->params = array(':PayerId' => $payerId, ':EventId' => $eventId);

    return $model->findAll($criteria);
  }

  /**
   * @return array Возвращает Total - сумма проведенного платежа и ErrorItems - позиции по которым возникли ошибки двойной оплаты
   */
  public function PayOrder()
  {
    $total = 0;
    $errorItems = array();
    $usedCoupons = array();
    foreach ($this->Items as $item)
    {
      if ($item->Deleted != 0)
      {
        continue;
      }
      $manager = $item->Product->ProductManager();
      if ($item->Paid == 0)
      {
        $priceDiscount = $item->PriceDiscount();
        if ($priceDiscount != $item->Price())
        {
          $couponActivated = $item->GetCouponActivated();
          if (!isset($usedCoupons[$couponActivated->CouponActivatedId]))
          {
            $usedCoupons[$couponActivated->CouponActivatedId] = array();
          }
          $usedCoupons[$couponActivated->CouponActivatedId][] = $item->OrderItemId;
        }
        $total += $priceDiscount;

        if (!empty($item->Owner))
        {
          if (!$manager->BuyProduct($item->Owner))
          {
            $errorItems[] = $item->OrderItemId;
          }
        }
      }
    }

    foreach ($usedCoupons as $couponActivatedId => $items)
    {
      foreach ($items as $itemId)
      {
        $link = new CouponActivatedOrderItemLink();
        $link->CouponActivatedId = $couponActivatedId;
        $link->OrderItemId = $itemId;
        $link->save();
      }
    }

    Order::SetPaidByOrderId($this->OrderId);

    if (! empty($this->OrderJuridical))
    {
      $this->OrderJuridical->Paid = 1;
      $this->OrderJuridical->Deleted = 1;
      $this->OrderJuridical->save();
    }

    return array('Total' => $total, 'ErrorItems' => $errorItems);
  }

  public function Price()
  {
    $price = 0;
    foreach ($this->Items as $item)
    {
      $price += $item->PriceDiscount();
    }
    return $price;
  }
}