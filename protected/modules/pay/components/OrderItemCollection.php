<?php
namespace pay\components;

/**
 * Class OrderItemCollection
 * @package pay\components
 */
class OrderItemCollection implements \Countable, \ArrayAccess, \IteratorAggregate
{

  /**
   * @var OrderItemCollectable
   */
  private $_items;

  /**
   * @var int
   */
  private $_eventId = null;

  /**
   * @var \pay\models\Order
   */
  private $_order = null;

  /**
   * @var float Скидка на коллекцию
   */
  private $_discount;

  /**
   * @param \pay\models\Order $order
   *
   * @return OrderItemCollection|OrderItemCollectable[]
   */
  public static function createByOrder(\pay\models\Order $order)
  {
    $items = [];
    foreach ($order->ItemLinks as $link)
    {
      $items[] = $link->OrderItem;
    }
    $collection = new self($items);
    $collection->_order = $order;
    return $collection;
  }

  /**
   * @param \pay\models\OrderItem[] $orderItems
   *
   * @return OrderItemCollection|OrderItemCollectable[]
   */
  public static function createByOrderItems($orderItems)
  {
    return new self($orderItems);
  }

  /**
   * @param \pay\models\OrderItem[] $orderItems
   *
   * @throws Exception
   */
  private function __construct($orderItems)
  {
    $this->position = 0;
    $this->_order = null;
    $this->_items = [];
    if (sizeof($orderItems) > 0)
    {
      foreach ($orderItems as $item)
      {
        if ($this->_eventId == null)
        {
          $this->_eventId = $item->Product->EventId;
        }
        elseif ($this->_eventId != $item->Product->EventId)
        {
          $message_items = '';
          $messageEvents = '';
          foreach ($orderItems as $item2)
          {
            $message_items .= ' ' . $item2->Id;
            $messageEvents .= ' ' . $item2->Product->EventId;
          }
          throw new Exception('Попытка создать коллекцию с заказами из разных мероприятий. (' . $message_items . ', ' . $messageEvents . ') Мероприятие: ' . $this->_eventId);
        }
        $this->_items[] = new OrderItemCollectable($item, $this);
      }
    }
  }

  /**
   * Вычисляет скидку для коллекции и кеширует её
   * @return float Скидка для коллекцию
   */
  public function getDiscount()
  {
    if ($this->_discount === null)
    {
      /** @var \pay\models\CollectionCoupon[] $coupons */
      $coupons = \pay\models\CollectionCoupon::model()->byEventId($this->_eventId)->findAll();
      $this->_discount = 0;
      foreach ($coupons as $coupon)
      {
        if ($coupon->isActive(!empty($this->_order) ? $this->_order->CreationTime : null))
          $this->_discount = max($this->_discount, $coupon->getTypeManager()->getDiscount($this));
      }
    }
    return $this->_discount;
  }

  /**
   * @return \pay\models\Order|null
   */
  public function getOrder()
  {
    return $this->_order;
  }

  /**
   * (PHP 5 &gt;= 5.1.0)<br/>
   * Count elements of an object
   * @link http://php.net/manual/en/countable.count.php
   * @return int The custom count as an integer.
   * </p>
   * <p>
   * The return value is cast to an integer.
   */
  public function count()
  {
    return sizeof($this->_items);
  }

  /**
   * (PHP 5 &gt;= 5.0.0)<br/>
   * Whether a offset exists
   * @link http://php.net/manual/en/arrayaccess.offsetexists.php
   *
   * @param mixed $offset <p>
   * An offset to check for.
   * </p>
   *
   * @return boolean true on success or false on failure.
   * </p>
   * <p>
   * The return value will be casted to boolean if non-boolean was returned.
   */
  public function offsetExists($offset)
  {
    return isset($this->_items[$offset]);
  }

  /**
   * (PHP 5 &gt;= 5.0.0)<br/>
   * Offset to retrieve
   * @link http://php.net/manual/en/arrayaccess.offsetget.php
   * @param mixed $offset <p>
   * The offset to retrieve.
   * </p>
   * @return mixed Can return all value types.
   */
  public function offsetGet($offset)
  {
    return isset($this->_items[$offset]) ? $this->_items[$offset] : null;
  }

  /**
   * (PHP 5 &gt;= 5.0.0)<br/>
   * Offset to set
   * @link http://php.net/manual/en/arrayaccess.offsetset.php
   *
   * @param mixed $offset <p>
   * The offset to assign the value to.
   * </p>
   * @param mixed $value <p>
   * The value to set.
   * </p>
   *
   * @throws \Exception
   * @return void
   */
  public function offsetSet($offset, $value)
  {
    throw new \Exception('OrderItemCollection is readonly.');
  }

  /**
   * (PHP 5 &gt;= 5.0.0)<br/>
   * Offset to unset
   * @link http://php.net/manual/en/arrayaccess.offsetunset.php
   *
   * @param mixed $offset <p>
   * The offset to unset.
   * </p>
   *
   * @throws \Exception
   * @return void
   */
  public function offsetUnset($offset)
  {
    throw new \Exception('OrderItemCollection is readonly.');
  }

  /**
   * (PHP 5 &gt;= 5.0.0)<br/>
   * Retrieve an external iterator
   * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
   * @return Traversable An instance of an object implementing <b>Iterator</b> or
   * <b>Traversable</b>
   */
  public function getIterator()
  {
    return new \pay\components\collection\Iterator($this);
  }
}