<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 19.01.12
 * Time: 16:42
 * To change this template use File | Settings | File Templates.
 */
class FoodProductManager extends BaseProductManager
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
    return array();
  }

  /**
   * @param array $params
   * @return Product
   */
  public function GetFilterProduct($params)
  {
    return $this->product;
  }

  /**
   * Отменяет покупку продукта на пользовтеля
   * @param User $user
   * @return bool
   */
  public function RollbackProduct($user)
  {
    return true;
  }
}
