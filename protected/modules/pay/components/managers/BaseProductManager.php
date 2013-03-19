<?php
namespace pay\components\managers;

abstract class BaseProductManager
{
  /**
   * @var \pay\models\Product
   */
  protected $product;

  /**
   * @param \pay\models\Product $product
   */
  public function __construct($product)
  {
    $this->product = $product;
  }


  public function __get($name)
  {
    if (!$this->product->getIsNewRecord() && in_array($name, $this->getProductAttributeNames()))
    {
      $attributes = $this->product->getProductAttributes();
      return isset($attributes[$name]) ? $attributes[$name]->Value : null;
    }
    else
    {
      return null;
    }
  }

  public function __set($name, $value)
  {
    if ($this->product->getIsNewRecord())
    {
      throw new \pay\components\Exception('Продукт еще не сохранен.');
    }
    if (in_array($name, $this->getProductAttributeNames()))
    {
      $attributes = $this->product->getProductAttributes();
      if (!isset($attributes[$name]))
      {
        $attribute = new \pay\models\ProductAttribute();
        $attribute->ProductId = $this->product->Id;
        $attribute->Name = $name;
        $this->product->setProductAttribute($attribute);
      }
      else
      {
        $attribute = $attributes[$name];
      }
      $attribute->Value = $value;
      $attribute->save();
    }
    else
    {
      throw new \pay\components\Exception('Данный продукт не содержит аттрибута с именем ' . $name);
    }
  }

  public function __isset($name)
  {
    if (!$this->product->getIsNewRecord() && in_array($name, $this->getProductAttributeNames()))
    {
      $attributes = $this->product->getProductAttributes();
      return isset($attributes[$name]);
    }
    else
    {
      return false;
    }
  }

  /**
   * Возвращает список необходимых аттрибутов для Product
   * @return string[]
   */
  public function getProductAttributeNames()
  {
    return array();
  }

  /**
   * Возвращает список необходимых аттрибутов для OrderItem
   * @return string[]
   */
  public function getOrderItemAttributeNames()
  {
    return array();
  }

  /**
   * Возвращает true - если продукт может быть приобретен пользователем, и false - иначе
   * @abstract
   * @param \user\models\User $user
   * @param array $params
   * @return bool
   */
  abstract public function checkProduct($user, $params = array());

  /**
   * Проверяет возможность покупки и оформляет покупку продукта на пользователя
   * @param \user\models\User $user
   * @param array $params
   *
   * @return bool
   */
  final public function buyProduct($user, $params = array())
  {
    if (!$this->checkProduct($user, $params))
    {
      return false;
    }
    return $this->internalBuyProduct($user, $params);
  }

  /**
   * Оформляет покупку продукта на пользователя
   * @abstract
   * @param \user\models\User $user
   * @param array $params
   * @return bool
   */
  abstract protected function internalBuyProduct($user, $params = array());
  
  /**
   * Отменяет покупку продукта на пользовтеля
   * @abstract
   * @param \user\models\User $user
   * @return bool 
   */
  abstract public function rollbackProduct($user);


  /**
   *
   * @abstract
   * @param \user\models\User $fromUser
   * @param \user\models\User $toUser
   * @return bool
   */
  abstract public function redirectProduct($fromUser, $toUser);

  /**
   * @param \user\models\User $payer
   * @param \user\models\User $owner
   * @param string|null $bookTime
   * @param array $attributes
   *
   * @return \pay\models\OrderItem
   * @throws \pay\components\Exception
   */
  public function createOrderItem(\user\models\User $payer, \user\models\User $owner, $bookTime = null, $attributes = array())
  {
    if (!$this->checkProduct($owner))
    {
      throw new \pay\components\Exception('Данный товар не может быть приобретен этим пользователем. Возможно уже куплен этот или аналогичный товар.');
    }

    $orderItem = \pay\models\OrderItem::model()->byProductId($this->product->Id)
        ->byPayerId($payer->Id)->byOwnerId($owner->Id)
        ->byDeleted(false)->find();
    if ($orderItem !== null && !$orderItem->Paid)
    {
      throw new \pay\components\Exception('Вы уже заказали этот товар');
    }

    foreach ($this->getOrderItemAttributeNames() as $key)
    {
      if (!isset($attributes[$key]))
      {
        throw new \pay\components\Exception('Не задан обязательный параметр ' . $key . ' при добавлении заказа.');
      }
    }

    $orderItem = new \pay\models\OrderItem();
    $orderItem->ProductId = $this->product->Id;
    $orderItem->PayerId = $payer->Id;
    $orderItem->OwnerId = $owner->Id;
    $orderItem->Booked = $bookTime === null ? null : date('Y-m-d H:i:s', time() + intval($bookTime));
    $orderItem->save();

    foreach ($this->getOrderItemAttributeNames() as $key)
    {
      $orderItem->setItemAttribute($key, $attributes[$key]);
    }

    return $orderItem;
  }

  /**
   * @abstract
   * @param array $params
   * @param string $filter
   * @return array
   */
  abstract public function filter($params, $filter);

  /**
   * @abstract
   * @param array $params
   * @return \pay\models\Product
   */
  abstract public function getFilterProduct($params);

  /**
   * @param \pay\models\OrderItem $orderItem
   * @return int
   */
  public function getPrice($orderItem)
  {
    return $this->product->GetPrice($orderItem->PaidTime);
  }

  /**
   * @param \pay\models\OrderItem $orderItem
   * @return string
   */
  public function getTitle($orderItem)
  {
    return $this->product->Title;
  }
}