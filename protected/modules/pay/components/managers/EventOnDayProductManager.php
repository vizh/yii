<?php
namespace pay\models\managers;

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
   * @param \user\models\User $user
   * @param array $params
   * @return bool
   */
  public function CheckProduct($user, $params = array())
  {
    list($roleId, $dayId) = $this->GetAttributes($this->GetAttributeNames());
    /** @var $eventUser \event\models\Participant */
    $eventUser = \event\models\Participant::model()->byEventId($this->product->EventId)->byUserId($user->UserId)->byDayId($dayId)->find();
    if (empty($eventUser))
    {
      return true;
    }
    if (empty($roleId))
    {
      return false;
    }
    $productRole = \event\models\Role::GetById($roleId);
    return !empty($productRole) && (empty($eventUser->Role) || $eventUser->Role->Priority < $productRole->Priority);
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
    list($roleId, $dayId) = $this->GetAttributes($this->GetAttributeNames());
    $role = \event\models\Role::GetById($roleId);
    if (empty($role))
    {
      return false;
    }
    /** @var $eventUser \event\models\Participant */
    $eventUser = \event\models\Participant::model()->byEventId($this->product->EventId)->byUserId($user->UserId)->byDayId($dayId)->find();
    if (empty($eventUser))
    {
      $day = \event\models\Day::model()->findByPk($dayId);
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

    list($roleId, $dayId) = $this->GetAttributes($this->GetAttributeNames());

    /** @var $participant \event\models\Participant */
    $participant = \event\models\Participant::model()->byUserId($user->UserId)->byEventId($this->product->EventId)->byDayId($dayId)->find();

    if ($participant != null)
    {
      $participant->UpdateRole($participant->Event->DefaultRole);
      return true;
    }
    return false;
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
    list($roleId, $dayId) = $this->GetAttributes($this->GetAttributeNames());

    /** @var $participant \event\models\Participant */
    $participant = \event\models\Participant::model()
      ->byUserId($fromUser->UserId)
      ->byEventId($this->product->EventId)
      ->byDayId($dayId)->find();

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

    /** @var $participant \event\models\Participant */
    $participant = \event\models\Participant::model()
      ->byUserId($toUser->UserId)
      ->byEventId($this->product->EventId)
      ->byDayId($dayId)->find();
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
