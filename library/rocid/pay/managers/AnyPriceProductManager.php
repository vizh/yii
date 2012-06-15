<?php

class AnyPriceProductManager extends BaseProductManager
{

  /**
     * Возвращает список доступных аттрибутов
     * @return string[]
     */
    public function GetAttributeNames()
    {
      return array();
    }

  /**
     * Возвращает список необходимых параметров для OrderItem
     * @return string[]
     */
    public function GetOrderParamNames()
    {
      return array('Price');
    }

  /**
   * Возвращает true - если продукт может быть приобретен пользователем, и false - иначе
   * @param User $user
   * @param array $params
   * @return bool
   */
  public function CheckProduct($user, $params = array())
  {
    // TODO: Implement CheckProduct() method.
    return true;
  }

  /**
   * Оформляет покупку продукта на пользователя
   * @param User $user
   * @param array $params
   * @return bool
   */
  public function BuyProduct($user, $params = array())
  {
    // TODO: Implement BuyProduct() method.
    return true;
  }

  /**
   * @param array $params
   * @param string $filter
   * @return array
   */
  public function Filter($params, $filter)
  {
    // TODO: Implement Filter() method.
    return array();
  }

  /**
   * @param array $params
   * @return Product
   */
  public function GetFilterProduct($params)
  {
    // TODO: Implement GetFilterProduct() method.
    return $this->product;
  }

  /**
   * @param OrderItem $orderItem
   * @return int
   */
  public function GetPrice($orderItem)
  {
    $price = parent::GetPrice($orderItem);
    $priceParam = $orderItem->GetParam('Price')->Value;
    return $price * $priceParam;
  }

}