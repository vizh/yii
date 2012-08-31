<?php
namespace pay\models\managers;

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
   * @param \user\models\User $user
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
   * @param \user\models\User $user
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
   * @return \pay\models\Product
   */
  public function GetFilterProduct($params)
  {
    return $this->product;
  }

  /**
   * Отменяет покупку продукта на пользовтеля
   * @param \user\models\User $user
   * @return bool
   */
  public function RollbackProduct($user)
  {
    // TODO: Implement RollbackProduct() method.
  }

  /**
   *
   * @param \user\models\User $fromUser
   * @param \user\models\User $toUser
   * @return bool
   */
  public function RedirectProduct($fromUser, $toUser)
  {
    // TODO: Implement RedirectProduct() method.
  }
}
