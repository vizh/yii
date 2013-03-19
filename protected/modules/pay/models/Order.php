<?php
namespace pay\models;

/**
 * @property int $Id
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
 * @property \event\models\Event $Event
 */
class Order extends \CActiveRecord
{
  const BookDayCount = 5;

  /**
   * @param string $className
   *
   * @return Order
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'PayOrder';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'ItemLinks' => array(self::HAS_MANY, '\pay\models\OrderLinkOrderItem', 'OrderId'),
      'OrderJuridical' => array(self::HAS_ONE, '\pay\models\OrderJuridical', 'OrderId'),
      'Payer' => array(self::BELONGS_TO, '\user\models\User', 'PayerId'),
      'Event' => array(self::BELONGS_TO, '\event\models\Event', 'EventId')
    );
  }

  /**
   * @param int $payerId
   * @param bool $useAnd
   *
   * @return Order
   */
  public function byPayerId($payerId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."PayerId" = :PayerId';
    $criteria->params = array('PayerId' => $payerId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param int $eventId
   * @param bool $useAnd
   *
   * @return Order
   */
  public function byEventId($eventId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."EventId" = :EventId';
    $criteria->params = array('EventId' => $eventId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param bool $juridical
   * @param bool $useAnd
   *
   * @return Order
   */
  public function byJuridical($juridical, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = ($juridical ? '' : 'NOT ') . '"t"."Juridical"';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param bool $paid
   * @param bool $useAnd
   * @return OrderItem
   */
  public function byPaid($paid, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = ($paid ? '' : 'NOT ') . '"t"."Paid"';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param bool $deleted
   * @param bool $useAnd
   *
   * @return OrderItem
   */
  public function byDeleted($deleted, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = ($deleted ? '' : 'NOT ') . '"t"."Deleted"';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
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
      $priceDiscount = $link->OrderItem->getPriceDiscount();
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


  /**
   * Заполняет счет элементами заказа. Возвращает значение Total (сумма заказа)
   *
   * @param \user\models\User $user
   * @param \event\models\Event $event
   * @param bool $juridical
   * @param array $juridicalData
   *
   * @throws \pay\components\Exception
   * @return int
   */
  public function create($user, $event, $juridical = false, $juridicalData = array())
  {
    $unpaidItems = $this->getUnpaidItems($user, $event);
    if (empty($unpaidItems))
    {
      throw new \pay\components\Exception('У вас нет не оплаченных товаров, для выставления счета.');
    }

    $this->PayerId = $user->Id;
    $this->EventId = $event->Id;
    $this->Juridical = $juridical;
    $this->save();


    $total = 0;
    foreach ($unpaidItems as $item)
    {
      $total += $item->getPriceDiscount();
      $orderLink = new OrderLinkOrderItem();
      $orderLink->OrderId = $this->Id;
      $orderLink->OrderItemId = $item->Id;
      $orderLink->save();

      if ($juridical) //todo: костыль для РИФ+КИБ проживания, продумать адекватное выставление сроков бронирования
      {
        if ($item->Booked != null)
        {
          $item->Booked = $this->getBookEnd($item->CreationTime);
        }
        $item->PaidTime = $this->CreationTime;
        $item->save();
      }
    }

    if ($juridical)
    {
      $orderJuridical= new OrderJuridical();
      $orderJuridical->OrderId = $this->Id;
      $orderJuridical->Name = $juridicalData['Name'];
      $orderJuridical->Address = $juridicalData['Address'];
      $orderJuridical->INN = $juridicalData['INN'];
      $orderJuridical->KPP = $juridicalData['KPP'];
      $orderJuridical->Phone = $juridicalData['Phone'];
      $orderJuridical->Fax = $juridicalData['Fax'];
      $orderJuridical->PostAddress = $juridicalData['PostAddress'];
      $orderJuridical->save();
    }

    return $total;
  }

  /**
   * @param \user\models\User $user
   * @param \event\models\Event $event
   *
   * @return \pay\models\OrderItem[]
   */
  public function getUnpaidItems($user, $event)
  {
    $items = OrderItem::getFreeItems($user->Id, $event->Id);
    /** @var $unpaidItems OrderItem[] */
    $unpaidItems = array();
    foreach ($items as $item)
    {
      if (!$item->Paid)
      {
        if ($item->Product->getManager()->checkProduct($item->Owner))
        {
          $unpaidItems[] = $item;
        }
        else
        {
          $item->delete();
        }
      }
    }
    return $unpaidItems;
  }

  /**
   * @static
   * @param string $start
   * @return string format Y-m-d H:i:s
   */
  private function getBookEnd($start)
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

  public function getPrice()
  {
    $price = 0;
    foreach ($this->ItemLinks as $link)
    {
      $price += $link->OrderItem->getPriceDiscount();
    }
    return $price;
  }

  public function delete()
  {
    if ($this->Paid || $this->Deleted || !$this->Juridical)
    {
      return false;
    }

    $this->Deleted = true;
    $this->DeletionTime = date('Y-m-d H:i:s');
    $this->save();

    return true;
  }


}