<?php
namespace pay\components;

use Traversable;

class OrderItemCollection implements \Countable, \ArrayAccess, \IteratorAggregate
{

  /**
   * @var OrderItemCollectable
   */
  private $items;

  /**
   * @var int
   */
  private $eventId = null;

  /**
   * @param \pay\models\OrderItem[] $orderItems
   *
   * @throws Exception
   */
  function __construct($orderItems)
  {
    $this->position = 0;
    $this->order = null;
    $this->items = [];
    if (sizeof($orderItems) > 0)
    {
      $this->eventId = $orderItems[0]->Product->EventId;
      foreach ($orderItems as $item)
      {
        if ($this->eventId != $item->Product->EventId)
        {
          throw new Exception('Попытка создать коллекцию с заказами из разных мероприятий');
        }
        $this->items[] = new OrderItemCollectable($item, $this);
      }
    }
  }

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
    $collection = new OrderItemCollection($items);
    $collection->order = $order;
    return $collection;
  }

  /**
   * @param \pay\models\OrderItem[] $orderItems
   *
   * @return OrderItemCollection|OrderItemCollectable[]
   */
  public static function createByOrderItems($orderItems)
  {
    return new OrderItemCollection($orderItems);
  }

  private $discount;

  public function getDiscount()
  {
    if ($this->eventId != 688)
    {
      return 0;
    }
    if ($this->discount === null)
    {
      $coupon = new \pay\components\collection\CountCoupon();
      $this->discount = $coupon->getDiscount($this);
    }
    return $this->discount;
  }

  /**
   * @var \pay\models\Order
   */
  private $order = null;

  /**
   * @return \pay\models\Order|null
   */
  public function getOrder()
  {
    return $this->order;
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
    return sizeof($this->items);
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
    return isset($this->items[$offset]);
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
    return isset($this->items[$offset]) ? $this->items[$offset] : null;
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