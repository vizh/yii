<?php
namespace pay\components\managers;


class Ticket extends BaseProductManager
{
  public function getProductAttributeNames()
  {
    return ['EventId', 'Count'];
  }


  public function checkProduct($user, $params = [])
  {
    return true;
  }

  /**
   * Оформляет покупку продукта на пользователя
   *
   * @param \user\models\User $user
   * @param \pay\models\OrderItem $orderItem
   * @param array $params
   *
   * @return bool
   */
  protected function internalBuyProduct($user, $orderItem = null, $params = array())
  {
    $coupons = [];
    for ($i = 0; $i < intval($params['Count']); $i++)
    {
      $coupon = new \pay\models\Coupon();
      $coupon->EventId = $params['EventId'];
      $coupon->ProductId = $this->product->Id;
      $coupon->Code = 'ticket-'.$coupon->generateCode();
      $coupon->Discount = 1;
      $coupon->IsTicket = true;
      $coupon->save();
      $coupons[] = $coupon;
    }

    // Отправляем письмо с покупкой текста

    // отправляем письма
    // TODO: Implement internalBuyProduct() method.
  }

  /**
   * Отменяет покупку продукта на пользовтеля
   * @param \user\models\User $user
   * @return bool
   */
  public function rollbackProduct($user)
  {
    //Удалить промокоды
    // TODO: Implement rollbackProduct() method.
  }

  /**
   *
   * @param \user\models\User $fromUser
   * @param \user\models\User $toUser
   * @param array $params
   *
   * @return bool
   */
  protected function internalChangeOwner($fromUser, $toUser, $params = array())
  {
    //Перенести промокоды
    // TODO: Implement internalChangeOwner() method.
  }

  public function filter($params, $filter)
  {
    return [];
  }

  public function getFilterProduct($params)
  {
    return $this->product;
  }
}