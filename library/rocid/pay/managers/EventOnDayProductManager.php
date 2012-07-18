<?php

class EventOnDayProductManager extends BaseProductManager
{
  /**
   * Возвращает список доступных аттрибутов
   * @return string[]
   */
  public function GetAttributeNames()
  {
    return array('RoleId', 'DayId');
  }

  /**
   * Возвращает true - если продукт может быть приобретен пользователем, и false - иначе
   * @param User $user
   * @param array $params
   * @return bool
   */
  public function CheckProduct($user, $params = array())
  {
    list($roleId, $dayId) = $this->GetAttributes($this->GetAttributeNames());
    $eventUser = EventUser::model()->byEventId($this->product->EventId)->byUserId($user->UserId)->byDayId($dayId)->find();
    if (empty($eventUser))
    {
      return true;
    }
    if (empty($roleId))
    {
      return false;
    }
    $productRole = EventRoles::GetById($roleId);
    return !empty($productRole) && (empty($eventUser->EventRole) || $eventUser->EventRole->Priority < $productRole->Priority);
  }

  /**
   * Оформляет покупку продукта на пользователя
   * @param User $user
   * @param array $params
   * @return bool
   */
  public function BuyProduct($user, $params = array())
  {
    if (!$this->CheckProduct($user))
    {
      return false;
    }
    list($roleId, $dayId) = $this->GetAttributes($this->GetAttributeNames());
    $role = EventRoles::GetById($roleId);
    if (empty($role))
    {
      return false;
    }
    /** @var $eventUser EventUser */
    $eventUser = EventUser::model()->byEventId($this->product->EventId)->byUserId($user->UserId)->byDayId($dayId)->find();
    if (empty($eventUser))
    {
      $day = EventDay::model()->findByPk($dayId);
      if (empty($day))
      {
        return false;
      }
      $this->product->Event->RegisterUserOnDay($day, $user, $role);
    }
    else
    {
      $eventUser->UpdateRole($role);
    }
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
    $orderItem = OrderItem::model()->find(
      't.Paid = 1 AND t.OwnerId = :OwnerId AND t.ProductId = :ProductId',
      array(
        ':OwnerId' => $user->UserId,
        ':ProductId' => $this->product->ProductId
      ));

    if ( $orderItem != null)
    {
      $orderItem->Paid = 0;
      $orderItem->PaidTime = null;
      $orderItem->save();
    }
    else
    {
      return false;
    }

    $eventUser = EventUser::GetByUserEventId($user->UserId, $this->product->EventId);
    if ($eventUser != null)
    {
      $eventUser->UpdateRole($eventUser->Event->DefaultRole);
      return true;
    }
    return false;
  }
}
