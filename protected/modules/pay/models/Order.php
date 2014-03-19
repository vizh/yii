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
 * @property bool $Receipt
 * @property int $TemplateId
 * @property string $Number
 *
 *
 * @property OrderLinkOrderItem[] $ItemLinks
 * @property OrderJuridical $OrderJuridical
 * @property \user\models\User $Payer
 * @property \event\models\Event $Event
 * @property OrderJuridicalTemplate $Template
 *
 * @method \pay\models\Order findByPk()
 * @method \pay\models\Order find()
 * @method \pay\models\Order[] findAll()
 */
class Order extends \CActiveRecord
{
  const BookDayCount = 5;
  const PayTypeJuridical = 'Juridical';

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
      'Event' => array(self::BELONGS_TO, '\event\models\Event', 'EventId'),
      'Template' => [self::BELONGS_TO, '\pay\models\OrderJuridicalTemplate', 'TemplateId']
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
   * @param $bankTransfer
   * @param bool $useAnd
   *
   * @return Order
   */
  public function byBankTransfer($bankTransfer, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = ($bankTransfer ? '' : 'NOT ') . '("t"."Juridical" OR "t"."Receipt")';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param bool $juridical
   * @param bool $useAnd
   * @return $this
   */
  public function byJuridical($juridical, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = ($juridical ? '' : 'NOT ') . '"t"."Juridical"';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param bool $receipt
   * @param bool $useAnd
   * @return $this
   */
  public function byReceipt($receipt, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = ($receipt ? '' : 'NOT ') . '"t"."Receipt"';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param bool $paid
   * @param bool $useAnd
   * @return Order
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
   * @return Order
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
    $collection = \pay\components\OrderItemCollection::createByOrder($this);
    $total = 0;
    $errorItems = array();
    $activations = array();

    foreach ($collection as $item)
    {
      $activation = $item->getOrderItem()->getCouponActivation();
      if ($item->getOrderItem()->activate($this))
      {
        if ($activation !== null)
        {
          $activations[$activation->Id][] = $item->getOrderItem()->Id;
        }
      }
      else
      {
        $errorItems[] = $item->getOrderItem()->Id;
      }
      $total += $item->getPriceDiscount();
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
    $this->Total = $total;
    $this->save();

    \partner\models\PartnerCallback::pay($this->Event, $this, strtotime($this->CreationTime));
    
    $event = new \CModelEvent($this, array('total' => $total));
    $this->onActivate($event);
    
    return array('Total' => $total, 'ErrorItems' => $errorItems);
  }
  
  
  
  public function onActivate($event)
  {
    $oldLanguage = \Yii::app()->getLanguage();
    $language = $this->Payer->Language != null ? $this->Payer->Language : 'ru';
    \Yii::app()->setLanguage($language);
    /** @var $sender Order */
    $sender = $event->sender;
    $class = \Yii::getExistClass('\pay\components\handlers\order\activate', ucfirst($sender->Event->IdName), 'Base');
    /** @var $mail \event\components\handlers\register\Base */
    $mail = new $class(new \mail\components\mailers\PhpMailer(), $event);
    $mail->send();
    \Yii::app()->setLanguage($oldLanguage);
  }

  /**
   * Заполняет счет элементами заказа. Возвращает значение Total (сумма заказа)
   *
   * @param \user\models\User $user
   * @param \event\models\Event $event
   * @param bool $juridical
   * @param array $juridicalData
   * @param bool $receipt
   *
   * @throws \pay\components\Exception
   * @return int
   */
  public function create($user, $event, $juridical = false, $juridicalData = [], $receipt = false)
  {
    $account = \pay\models\Account::model()->byEventId($event->Id)->find();
    if ($account == null)
    {
      throw new \pay\components\Exception(sprintf('Для мероприятия %s,%s,%s не определен платежный аккаунт', $event->Id, $event->IdName, $event->Title));
    }

    $finder = \pay\components\collection\Finder::create($event->Id, $user->Id);
    $collection = $finder->getUnpaidFreeCollection();
    if ($collection->count() == 0)
    {
      throw new \pay\components\Exception('У вас нет не оплаченных товаров, для выставления счета.');
    }

    \partner\models\PartnerCallback::tryPay($event, $user);

    $this->PayerId = $user->Id;
    $this->EventId = $event->Id;
    $this->Juridical = $juridical;
    $this->Receipt = $receipt;
    $this->save();
    $this->refresh();

    $total = 0;
    foreach ($collection as $item)
    {
      $total += $item->getPriceDiscount();
      $orderLink = new OrderLinkOrderItem();
      $orderLink->OrderId = $this->Id;
      $orderLink->OrderItemId = $item->getOrderItem()->Id;
      $orderLink->save();

      if ($juridical || $receipt) //todo: костыль для РИФ+КИБ проживания, продумать адекватное выставление сроков бронирования
      {
        if ($item->getOrderItem()->Booked != null)
        {
          $item->getOrderItem()->Booked = $this->getBookEnd($item->getOrderItem()->CreationTime);
        }
        $item->getOrderItem()->PaidTime = $this->CreationTime;
        $item->getOrderItem()->save();
      }
    }

    if ($juridical || $receipt)
    {
      $orderJuridical= new OrderJuridical();
      $orderJuridical->OrderId = $this->Id;
      if (!$receipt)
      {
        $orderJuridical->Name = $juridicalData['Name'];
        $orderJuridical->Address = $juridicalData['Address'];
        $orderJuridical->INN = $juridicalData['INN'];
        $orderJuridical->KPP = $juridicalData['KPP'];
        $orderJuridical->Phone = $juridicalData['Phone'];
        $orderJuridical->PostAddress = $juridicalData['PostAddress'];
      }
      $orderJuridical->save();

      $template = $juridical ? $account->OrderTemplate : $account->ReceiptTemplate;
      $this->TemplateId = $template->Id;
      $this->Number = $template->NumberFormat != null ? $template->getNextNumber() : null;
      $this->save();

      if ($this->Number == null)
      {
        $this->Number = $this->Id;
        $this->save();
      }
      
      $event = new \CModelEvent($this, ['payer' => $user, 'event' => $event, 'total' => $total]);
      $this->onCreateOrderJuridical($event);
    }
    else
    {
      $orders = Order::model()->byEventId($this->EventId)->byPaid(false)->byDeleted(false)
          ->byBankTransfer(false)->byPayerId($this->PayerId)->findAll();

      foreach ($orders as $order)
      {
        if ($order->Id != $this->Id)
        {
          $order->delete();
        }
      }
    }

    return $total;
  }
  
  public function onCreateOrderJuridical($event)
  {
    $oldLanguage = \Yii::app()->getLanguage();
    $language = $this->Payer->Language != null ? $this->Payer->Language : 'ru';
    \Yii::app()->setLanguage($language);
    $class = \Yii::getExistClass('\pay\components\handlers\orderjuridical\create', ucfirst($event->params['event']->IdName), 'Base');
    /** @var $mail \event\components\handlers\register\Base */
    $mail = new $class(new \mail\components\mailers\PhpMailer(), $event);
    $mail->send();
    \Yii::app()->setLanguage($oldLanguage);
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
    $collection = \pay\components\OrderItemCollection::createByOrder($this);
    $price = 0;
    foreach ($collection as $item)
    {
      $price += $item->getPriceDiscount();
    }
    return $price;
  }

  public function delete()
  {
    if ($this->Paid || $this->Deleted)
    {
      return false;
    }

    foreach ($this->ItemLinks as $link)
    {
      if ($link->OrderItem == null)
        continue;
      if ($link->OrderItem->Booked != null)
      {
        $link->OrderItem->Booked = date('Y-m-d H:i:s', time() + 5 * 60 * 60);
      }
      $link->OrderItem->PaidTime = null;
      $link->OrderItem->save();
    }

    $this->Deleted = true;
    $this->DeletionTime = date('Y-m-d H:i:s');
    $this->save();

    return true;
  }

  private static $SecretKey = '7deSAJ42VhzHRgYkNmxz';
  public function getHash()
  {
    return substr(md5($this->Id.self::$SecretKey), 0, 16);
  }

  public function checkHash($hash)
  {
    return $hash == $this->getHash();
  }

  public function getUrl($clear = false)
  {
    $params = array(
      'orderId' => $this->Id,
      'hash' => $this->getHash()
    );
    if ($clear)
    {
      $params['clear'] = 'clear';
    }
    return \Yii::app()->createAbsoluteUrl('/pay/order/index', $params);
  }

  /**
   * @return bool
   */
  public function getIsBankTransfer()
  {
    return $this->Juridical || $this->Receipt;
  }


  /**
   * @return string
   */
  public function getPayType()
  {
    if (!$this->Juridical)
    {
      /** @var $log \pay\models\Log */
      $log = \pay\models\Log::model()->byOrderId($this->Id)->find();
      if ($log !== null)
      {
        return $log->PaySystem;
      }
    }
    else
    {
      return self::PayTypeJuridical;
    }
  }
}