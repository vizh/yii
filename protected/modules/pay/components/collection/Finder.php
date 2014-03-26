<?php
namespace pay\components\collection;

use \pay\components\OrderItemCollection;
use \pay\components\OrderItemCollectable;

class Finder
{
  private $eventId;
  private $payerId;

  private function __construct($eventId, $payerId)
  {
    $this->eventId = $eventId;
    $this->payerId = $payerId;
  }

  private function __clone()
  {

  }

  private static $instances = [];

  /**
   * @param int $eventId
   * @param int $payerId
   *
   * @return Finder
   */
  public static function create($eventId, $payerId)
  {
    if (!isset(self::$instances[$eventId]))
    {
      self::$instances[$eventId] = [];
    }
    if (!isset(self::$instances[$eventId][$payerId]))
    {
      self::$instances[$eventId][$payerId] = new self($eventId, $payerId);
    }

    return self::$instances[$eventId][$payerId];
  }

  private $unpaidFreeCollection;

  /**
   * @return OrderItemCollectable[]|OrderItemCollection
   */
  public function getUnpaidFreeCollection()
  {
    if ($this->unpaidFreeCollection == null)
    {
      $idList = [];
      foreach ($this->getUnpaidOrderCollections() as $collection)
      {
        foreach ($collection as $item)
        {
          /** @var $item OrderItemCollectable */
          $idList[] = $item->getOrderItem()->Id;
        }
      }
      $criteria = new \CDbCriteria();
      $criteria->addNotInCondition('"t"."Id"', $idList);
      $orderItems = \pay\models\OrderItem::model()
          ->byEventId($this->eventId)->byPayerId($this->payerId)
          ->byPaid(false)->byBooked(true)->byDeleted(false)->findAll($criteria);

      foreach ($orderItems as $key => $orderItem)
      {
        if (!$orderItem->check())
        {
          $orderItem->delete();
          unset($orderItems[$key]);
        }
        elseif ($orderItem->getPrice() == 0)
        {
          $orderItem->activate();
          if ($this->paidFreeCollections !== null)
          {
            $this->paidFreeCollections[] = OrderItemCollection::createByOrderItems([$orderItem]);
          }
          unset($orderItems[$key]);
        }
      }
      $this->unpaidFreeCollection = OrderItemCollection::createByOrderItems($orderItems);
    }

    return $this->unpaidFreeCollection;
  }

  private $unpaidOrderCollections = null;

  /**
   * @return OrderItemCollection[]
   */
  public function getUnpaidOrderCollections()
  {
    if ($this->unpaidOrderCollections === null)
    {
      $orders = \pay\models\Order::model()
          ->byEventId($this->eventId)->byPayerId($this->payerId)
          ->byPaid(false)->byDeleted(false)->byLongPayment(true)->findAll();
      $this->unpaidOrderCollections = [];
      foreach ($orders as $order)
      {
        $this->unpaidOrderCollections[] = OrderItemCollection::createByOrder($order);
      }
    }
    return $this->unpaidOrderCollections;
  }

  private $paidOrderCollections = null;

  public function getPaidOrderCollections()
  {
    if ($this->paidOrderCollections === null)
    {
      $orders = \pay\models\Order::model()
          ->byEventId($this->eventId)->byPayerId($this->payerId)
          ->byPaid(true)->findAll();
      $this->paidOrderCollections = [];
      foreach ($orders as $order)
      {
        $this->paidOrderCollections[] = OrderItemCollection::createByOrder($order);
      }
    }
    return $this->paidOrderCollections;
  }

  private $paidFreeCollections = null;

  public function getPaidFreeCollections()
  {
    if ($this->paidFreeCollections == null)
    {
      $this->paidFreeCollections = [];
      $idList = [];
      foreach ($this->getPaidOrderCollections() as $collection)
      {
        foreach ($collection as $item)
        {
          /** @var $item OrderItemCollectable */
          $idList[] = $item->getOrderItem()->Id;
        }
      }
      $criteria = new \CDbCriteria();
      $criteria->addNotInCondition('"t"."Id"', $idList);
      $orderItems = \pay\models\OrderItem::model()
          ->byEventId($this->eventId)->byPayerId($this->payerId)
          ->byPaid(true)->findAll($criteria);
      foreach ($orderItems as $orderItem)
      {
        $this->paidFreeCollections[] = OrderItemCollection::createByOrderItems([$orderItem]);
      }
    }

    return $this->paidFreeCollections;
  }

}
