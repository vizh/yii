<?php
namespace pay\models\managers;

class EventProductManager extends BaseProductManager
{

  private static $roles;
  private static function GetRoles()
  {
    if (empty(self::$roles))
    {
      self::$roles = \event\models\Role::GetAll();
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
   * @param \user\models\User $user
   * @param array $params
   * @return bool
   */
  public function CheckProduct($user, $params = array())
  {
    $eventUser = \event\models\Participant::GetByUserEventId($user->UserId, $this->product->EventId);
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
    $roles = \event\models\Role::GetAll();
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
   * @param \user\models\User $user
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

    $role = \event\models\Role::GetById($roleId);
    if (empty($role))
    {
      return false;
    }

    $eventUser = \event\models\Participant::GetByUserEventId($user->UserId, $this->product->EventId);
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
    /** @var $orderItem \pay\models\OrderItem */
    $orderItem = \pay\models\OrderItem::model()->find(
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

    $eventUser = \event\models\Participant::GetByUserEventId($user->UserId, $this->product->EventId);
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
   * @return \pay\models\Product
   */
  public function GetFilterProduct($params)
  {
    return $this->product;
  }

  /**
   *
   * @param \user\models\User $fromUser
   * @param \user\models\User $toUser
   * @return bool
   */
  public function RedirectProduct($fromUser, $toUser)
  {
    if (!$this->CheckProduct($toUser))
    {
      return false;
    }
    list($roleId) = $this->GetAttributes($this->GetAttributeNames());

    $participant = \event\models\Participant::GetByUserEventId($fromUser->UserId, $this->product->EventId);
    if ($participant != null)
    {
      if ($participant->RoleId == $roleId)
      {
        $participant->delete();
      }
    }

    $role = \event\models\Role::GetById($roleId);
    if (empty($role))
    {
      return false;
    }

    $participant = \event\models\Participant::GetByUserEventId($toUser->UserId, $this->product->EventId);
    if (empty($participant))
    {
      $this->product->Event->RegisterUser($toUser, $role);
    }
    else
    {
      $participant->UpdateRole($role);
    }

    return true;
  }
}
