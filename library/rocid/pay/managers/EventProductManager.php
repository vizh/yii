<?php
AutoLoader::Import('library.rocid.event.*');

class EventProductManager extends BaseProductManager
{

  private static $roles;
  private static function GetRoles()
  {
    if (empty(self::$roles))
    {
      self::$roles = EventRoles::GetAll();
    }

    return self::$roles;
  }

  /**
   * Возвращает список доступных аттрибутов
   * @return string[]
   */
  public function GetAttributeNames()
  {
    return array('RoleId');
  }


  /**
   * Возвращает true - если продукт может быть приобретен пользователем, и false - иначе
   * @param User $user
   * @param array $params
   * @return bool
   */
  public function CheckProduct($user, $params = array())
  {
    $eventUser = EventUser::GetByUserEventId($user->UserId, $this->product->EventId);
    if (empty($eventUser))
    {
      return true;
    }
    $roleId = null;
    foreach ($this->product->Attributes as $attribute)
    {
      if ($attribute->Name == 'RoleId')
      {
        $roleId = intval($attribute->Value);
      }
    }
    $roles = EventRoles::GetAll();
    $eventRole = null;
    $productRole = null;
    if (empty($roleId))
    {
      return false;
    }
    foreach ($roles as $role)
    {
      if ($role->RoleId == $roleId)
      {
        $productRole = $role;
      }

      if ($role->RoleId == $eventUser->RoleId)
      {
        $eventRole = $role;
      }
    }
    return !empty($productRole) && (empty($eventRole) || $eventRole->Priority < $productRole->Priority);
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

    $roleId = null;
    foreach ($this->product->Attributes as $attribute)
    {
      if ($attribute->Name == 'RoleId')
      {
        $roleId = intval($attribute->Value);
      }
    }

    $role = EventRoles::GetById($roleId);
    if (empty($role))
    {
      return false;
    }

    $eventUser = EventUser::GetByUserEventId($user->UserId, $this->product->EventId);
    if (empty($eventUser))
    {
      $this->product->Event->RegisterUser($user, $role);
    }
    else
    {
      $eventUser->UpdateRole($role);
    }

    return true;
  }

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
