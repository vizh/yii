<?php
namespace pay\models\managers;

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
   * @param \user\models\User $user
   * @param array $params
   * @return bool
   */
  abstract public function CheckProduct($user, $params = array());

  /**
   * Оформляет покупку продукта на пользователя
   * @abstract
   * @param \user\models\User $user
   * @param array $params
   * @return bool
   */
  abstract public function BuyProduct($user, $params = array());
  
  /**
   * Отменяет покупку продукта на пользовтеля
   * @abstract
   * @param \user\models\User $user
   * @return bool 
   */
  abstract public function RollbackProduct($user);


  /**
   *
   * @abstract
   * @param \user\models\User $fromUser
   * @param \user\models\User $toUser
   * @return bool
   */
  abstract public function RedirectProduct($fromUser, $toUser);

    /**
   *
   * @param \user\models\User $payer
   * @param \user\models\User $owner
   * @param int $bookTime
   * @param array
   * @return \pay\models\OrderItem
   * @throws \pay\models\PayException
   */
  public function CreateOrderItem($payer, $owner, $bookTime = null, $params = array())
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
  abstract public function Filter($params, $filter);

  /**
   * @abstract
   * @param array $params
   * @return \pay\models\Product
   */
  abstract public function GetFilterProduct($params);

  /**
   * @param \pay\models\OrderItem $orderItem
   * @return int
   */
  public function GetPrice($orderItem)
  {
    return $this->product->GetPrice($orderItem->PaidTime);
  }

  /**
   * @param \pay\models\OrderItem $orderItem
   * @return string
   */
  public function GetTitle($orderItem)
  {
    return $this->product->Title;
  }
}