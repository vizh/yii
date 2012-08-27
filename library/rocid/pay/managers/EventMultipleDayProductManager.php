<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alaris
 * Date: 8/27/12
 * Time: 6:22 PM
 * To change this template use File | Settings | File Templates.
 */
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
   * @param User $user
   * @param array $params
   * @return bool
   */
  public function CheckProduct($user, $params = array())
  {
    list($roleId) = $this->GetAttributes($this->GetAttributeNames());

    /** @var $eventUsers EventUser[] */
    $eventUsers = EventUser::model()->byEventId($this->product->EventId)->byUserId($user->UserId)->with('EventRole')->findAll();
    if (empty($eventUsers))
    {
      return true;
    }
    if (empty($roleId))
    {
      return false;
    }
    $productRole = EventRoles::GetById($roleId);
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
        if (empty($eUser->EventRole) || $eUser->EventRole->Priority < $productRole->Priority)
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
    list($roleId) = $this->GetAttributes($this->GetAttributeNames());
    $role = EventRoles::GetById($roleId);
    if (empty($role))
    {
      return false;
    }
    /** @var $eventUsers EventUser[] */
    $eventUsers = EventUser::model()->byEventId($this->product->EventId)->byUserId($user->UserId)->with('EventRole')->findAll();

    $days = $this->product->Event->Days;
    $daysByKey = array();
    foreach ($days as $day)
    {
      $daysByKey[$day->DayId] = $day;
    }

    foreach ($eventUsers as $eUser)
    {
      unset($daysByKey[$eUser->DayId]);
      if ($eUser->EventRole->Priority > $role->Priority)
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