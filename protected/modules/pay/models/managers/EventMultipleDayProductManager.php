<?php
namespace pay\models\managers;

class EventMultipleDayProductManager extends BaseProductManager
{
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
    list($roleId) = $this->GetAttributes($this->GetAttributeNames());

    /** @var $eventUsers \event\models\Participant[] */
    $eventUsers = \event\models\Participant::model()->byEventId($this->product->EventId)->byUserId($user->UserId)->with('EventRole')->findAll();
    if (empty($eventUsers))
    {
      return true;
    }
    if (empty($roleId))
    {
      return false;
    }
    $productRole = \event\models\Role::GetById($roleId);
    if (empty($productRole))
    {
      return false;
    }
    $days = $this->product->Event->Days;
    $flag = sizeof($days) != sizeof($eventUsers);
    if (!$flag)
    {
      foreach ($eventUsers as $eUser)
      {
        if (empty($eUser->Role) || $eUser->Role->Priority < $productRole->Priority)
        {
          $flag = true;
          break;
        }
      }
    }
    return $flag;
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
    list($roleId) = $this->GetAttributes($this->GetAttributeNames());
    $role = \event\models\Role::GetById($roleId);
    if (empty($role))
    {
      return false;
    }
    /** @var $eventUsers \event\models\Participant[] */
    $eventUsers = \event\models\Participant::model()->byEventId($this->product->EventId)->byUserId($user->UserId)->with('EventRole')->findAll();

    $days = $this->product->Event->Days;
    $daysByKey = array();
    foreach ($days as $day)
    {
      $daysByKey[$day->DayId] = $day;
    }

    foreach ($eventUsers as $eUser)
    {
      unset($daysByKey[$eUser->DayId]);
      if ($eUser->Role->Priority > $role->Priority)
      {
        continue;
      }
      $eUser->UpdateRole($role);
    }

    foreach ($daysByKey as $day)
    {
      $this->product->Event->RegisterUserOnDay($day, $user, $role);
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

    /** @var $participants \event\models\Participant[] */
        $participants = \event\models\Participant::model()->byEventId($this->product->EventId)->byUserId($user->UserId)->findAll();
    if (!empty($participants))
    {
      foreach ($participants as $participant)
      {
        $participant->UpdateRole($this->product->Event->DefaultRole);
      }
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
    list($roleId) = $this->GetAttributes($this->GetAttributeNames());
    $role = \event\models\Role::GetById($roleId);
    if (empty($role))
    {
      return false;
    }

    /** @var $participants \event\models\Participant[] */
    $participants = \event\models\Participant::model()->byEventId($this->product->EventId)->byUserId($fromUser->UserId)->findAll();

    foreach ($participants as $participant)
    {
      if ($participant->RoleId == $roleId)
      {
        $participant->delete();
      }
    }

    /** @var $participants \event\models\Participant[] */
    $participants = \event\models\Participant::model()->byEventId($this->product->EventId)->byUserId($toUser->UserId)->with('EventRole')->findAll();

    $days = $this->product->Event->Days;
    $daysByKey = array();
    foreach ($days as $day)
    {
      $daysByKey[$day->DayId] = $day;
    }

    foreach ($participants as $participant)
    {
      unset($daysByKey[$participant->DayId]);
      if ($participant->Role->Priority > $role->Priority)
      {
        continue;
      }
      $participant->UpdateRole($role);
    }

    foreach ($daysByKey as $day)
    {
      $this->product->Event->RegisterUserOnDay($day, $toUser, $role);
    }

    return true;
  }
}