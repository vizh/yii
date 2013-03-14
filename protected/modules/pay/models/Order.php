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
   * @property bool $juridical
   * @property array $juridicalData
   *
   * @return int
   */
  public function fill($juridical = false, $juridicalData = array())
  {
    /** @var $items OrderItem[] */
    $items = OrderItem::model()
        ->byPayerId($this->PayerId)
        ->byEventId($this->EventId)
        ->byNotInOrders($this->PayerId, $this->EventId)
        ->byDeleted(false)->findAll();

    $total = 0;
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

    foreach ($items as $item)
    {
      if (!$item->Paid)
      {
        $total += $item->getPriceDiscount();
        $orderLink = new OrderLinkOrderItem();
        $orderLink->OrderId = $this->Id;
        $orderLink->OrderItemId = $this->Id;
        $orderLink->save();
        /**
         * todo: костыль для РИФ+КИБ проживания, продумать адекватное выставление сроков бронирования
         */
        if ($juridical)
        {
          if ($item->Booked != null)
          {
            $item->Booked = $this->getBookEnd($item->CreationTime);
          }
          $item->PaidTime = $this->CreationTime;
          $item->save();
        }
      }
    }

    return $total;
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
}