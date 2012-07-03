<?php

abstract class BaseProductManager
{
  /**
   * @var Product
   */
  protected $product;

  /**
   * @param Product $product
   */
  public function __construct($product)
  {
    $this->product = $product;
  }

  /**
   * Возвращает список доступных аттрибутов
   * @return string[]
   */
  public function GetAttributeNames()
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
   * Возвращает список необходимых параметров для OrderItem
   * @return string[]
   */
  public function GetOrderParamNames()
  {
    return array();
  }



  /**
   * Возвращает true - если продукт может быть приобретен пользователем, и false - иначе
   * @abstract
   * @param User $user
   * @param array $params
   * @return bool
   */
  abstract public function CheckProduct($user, $params = array());

  /**
   * Оформляет покупку продукта на пользователя
   * @abstract
   * @param User $user
   * @param array $params
   * @return bool
   */
  abstract public function BuyProduct($user, $params = array());

  /**
   *
   * @param User $payer
   * @param User $owner
   * @param int $bookTime
   * @param array
   * @return OrderItem
   * @throws PayException
   */
  public function CreateOrderItem($payer, $owner, $bookTime = null, $params = array())
  {
    $orderParams = $this->GetOrderParamNames();
    foreach ($orderParams as $key)
    {
      if (!isset($params[$key]))
      {
        throw new PayException('Не задан обязательный параметр ' . $key . ' при добавлении заказа.');
      }
    }

    $orderItem = new OrderItem();
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
  abstract public function Filter($params, $filter);

  /**
   * @abstract
   * @param array $params
   * @return Product
   */
  abstract public function GetFilterProduct($params);

  /**
   * @param OrderItem $orderItem
   * @return int
   */
  public function GetPrice($orderItem)
  {
    return $this->product->GetPrice($orderItem->PaidTime);
  }

  /**
   * @param OrderItem $orderItem
   * @return string
   */
  public function GetTitle($orderItem)
  {
    return $this->product->Title;
  }
}
