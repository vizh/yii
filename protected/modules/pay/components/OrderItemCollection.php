<?php
namespace pay\components;

use pay\components\collection\Iterator;
use pay\models\CollectionCoupon;
use pay\models\Order;
use pay\models\OrderItem;

/**
 * Class OrderItemCollection
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
    private $_eventId;

    /**
     * @var Order
     */
    private $_order;

    /**
     * @param Order $order
     * @return OrderItemCollection|OrderItemCollectable[]
     */
    public static function createByOrder(Order $order)
    {
        $items = [];
        foreach ($order->ItemLinks as $link) {
            $items[] = $link->OrderItem;
        }
        $collection = new self($items);
        $collection->_order = $order;
        $collection->applyCollectionCoupons();

        return $collection;
    }

    /**
     * @param OrderItem[] $orderItems
     *
     * @return OrderItemCollection|OrderItemCollectable[]
     */
    public static function createByOrderItems($orderItems)
    {
        $collection = new self($orderItems);
        $collection->applyCollectionCoupons();

        return $collection;
    }

    /**
     * @param OrderItem[] $orderItems
     * @throws Exception
     */
    private function __construct($orderItems)
    {
        $this->position = 0;
        $this->_order = null;
        $this->_items = [];
        if (sizeof($orderItems) > 0) {
            foreach ($orderItems as $item) {
                if ($this->_eventId == null) {
                    $this->_eventId = $item->Product->EventId;
                } elseif ($this->_eventId != $item->Product->EventId) {
                    $message_items = '';
                    $messageEvents = '';
                    foreach ($orderItems as $item2) {
                        $message_items .= ' '.$item2->Id;
                        $messageEvents .= ' '.$item2->Product->EventId;
                    }
                    throw new MessageException('Попытка создать коллекцию с заказами из разных мероприятий. ('.$message_items.', '.$messageEvents.') Мероприятие: '.$this->_eventId, MessageException::ORDER_ITEM_GROUP_CODE);
                }
                $this->_items[] = new OrderItemCollectable($item, $this);
            }
        }
    }

    /**
     * Применяет групповые скидки к коллекции, если они есть
     * @throws \CException
     */
    private function applyCollectionCoupons()
    {
        $time = !empty($this->_order) ? $this->_order->CreationTime : null;

        $coupons = CollectionCoupon::model()->byEventId($this->_eventId)->findAll();
        foreach ($coupons as $coupon) {
            if ($coupon->isActive($time)) {
                $coupon->getTypeManager()->apply($this);
            }
        }
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
        return new Iterator($this);
    }
}
