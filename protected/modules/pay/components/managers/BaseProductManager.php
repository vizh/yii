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
        $this->productAttributes[$name] = $attribute;
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


  public function GetAttributes($orderMap)
  {
    $attributes = array();
    foreach ($this->product->Attributes as $attribute)
    {
      if (in_array($attribute->Name, $orderMap))
      {
        $attributes[$attribute->Name] = $attribute->Value;
      }
    }

    $result = array();
    foreach ($orderMap as $attributeName)
    {
      if (isset($attributes[$attributeName]))
      {
        $result[] = $attributes[$attributeName];
      }
    }
    return $result;
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
   * Оформляет покупку продукта на пользователя
   * @abstract
   * @param \user\models\User $user
   * @param array $params
   * @return bool
   */
  abstract public function buyProduct($user, $params = array());
  
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
   *
   * @param \user\models\User $payer
   * @param \user\models\User $owner
   * @param int $bookTime
   * @param array
   * @return \pay\models\OrderItem
   * @throws \pay\models\PayException
   */
  public function createOrderItem($payer, $owner, $bookTime = null, $params = array())
  {
    $orderParams = $this->GetOrderParamNames();
    foreach ($orderParams as $key)
    {
      if (!isset($params[$key]))
      {
        throw new \pay\models\PayException('Не задан обязательный параметр ' . $key . ' при добавлении заказа.');
      }
    }

    $orderItem = new \pay\models\OrderItem();
    $orderItem->ProductId = $this->product->ProductId;
    $orderItem->PayerId = $payer->UserId;
    $orderItem->OwnerId = $owner->UserId;
    $orderItem->Booked = empty($bookTime) ? null : date('Y-m-d H:i:s', time() + intval($bookTime));
    $orderItem->CreationTime = date('Y-m-d H:i:s');
    $orderItem->save();

    foreach ($orderParams as $key)
    {
      $orderItem->AddParam($key, $params[$key]);
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