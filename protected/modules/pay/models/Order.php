<?php
namespace pay\models;

/**
 * @property int $OrderId
 * @property int $PayerId
 * @property int $EventId
 * @property bool $Paid
 * @property string $PaidTime
 * @property int $Total
 * @property bool $Juridical
 * @property string $CreationTime
 * @property bool $Deleted
 * @property string $DeletionTime
 *
 *
 * @property OrderLinkOrderItem[] $ItemLinks
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
      'ItemLinks' => array(self::HAS_MANY, '\pay\models\OrderLinkOrderItem', 'OrderId'),
      'OrderJuridical' => array(self::HAS_ONE, '\pay\models\OrderJuridical', 'OrderId'),
      'Payer' => array(self::BELONGS_TO, '\user\models\User', 'PayerId')
    );
  }

  /**
   * @return array Возвращает Total - сумма проведенного платежа и ErrorItems - позиции по которым возникли ошибки двойной оплаты
   */
  public function activate()
  {
    $total = 0;
    $errorItems = array();
    $activations = array();

    foreach ($this->ItemLinks as $link)
    {
      $priceDiscount = $link->OrderItem->PriceDiscount();
      $activation = $link->OrderItem->getCouponActivation();
      if ($link->OrderItem->activate())
      {
        if ($activation !== null)
        {
          $activations[$activation->Id][] = $link->OrderItem->Id;
        }
      }
      else
      {
        $errorItems[] = $link->OrderItem->Id;
      }
      $total += $priceDiscount;
    }

    foreach ($activations as $activationId => $items)
    {
      foreach ($items as $itemId)
      {
        $link = new CouponActivationLinkOrderItem();
        $link->CouponActivationId = $activationId;
        $link->OrderItemId = $itemId;
        $link->save();
      }
    }

    $this->Paid = true;
    $this->PaidTime = date('Y-m-d H:i:s');
    if ($this->Juridical)
    {
      $this->Total = $total;
    }
    $this->save();

    return array('Total' => $total, 'ErrorItems' => $errorItems);
  }



  /** todo: old methods */



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