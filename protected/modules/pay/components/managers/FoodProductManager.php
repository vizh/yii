<?php
namespace pay\components\managers;


use pay\models\OrderItem;

class FoodProductManager extends BaseProductManager
{

  /**
   * Возвращает true - если продукт может быть приобретен пользователем, и false - иначе
   * @param \user\models\User $user
   * @param array $params
   * @return bool
   */
  public function checkProduct($user, $params = array())
  {
    return true;
  }

  /**
   * Оформляет покупку продукта на пользователя
   * @param \user\models\User $user
   * @param null $orderItem
   * @param array $params
   *
   * @return bool
   */
  protected function internalBuy($user, $orderItem = null, $params = array())
  {
    return true;
  }

  /**
   * @param array $params
   * @param string $filter
   * @return array
   */
  public function filter($params, $filter)
  {
    return array();
  }

  /**
   * @param array $params
   * @return \pay\models\Product
   */
  public function getFilterProduct($params)
  {
    return $this->product;
  }

    /**
     * @inheritdoc
     */
    protected function internalRollback(OrderItem $orderItem)
    {

    }

  /**
   *
   * @param \user\models\User $fromUser
   * @param \user\models\User $toUser
   * @param array $params
   *
   * @return bool
   */
  public function internalChangeOwner($fromUser, $toUser, $params = array())
  {
    return true;
  }


}
