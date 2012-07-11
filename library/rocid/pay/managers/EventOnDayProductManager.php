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
}
