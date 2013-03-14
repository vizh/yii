<?php
namespace pay\components\managers;

/**
 * @property int $RoleId
 */
class EventProductManager extends BaseProductManager
{
  /**
   * @return array
   */
  public function getProductAttributeNames()
  {
    return array('RoleId');
  }


  /**
   * Возвращает true - если продукт может быть приобретен пользователем, и false - иначе
   * @param \user\models\User $user
   * @param array $params
   * @return bool
   */
  public function checkProduct($user, $params = array())
  {
    /** @var $participant \event\models\Participant */
    $participant = \event\models\Participant::model()
        ->byUserId($user->Id)
        ->byEventId($this->product->EventId)->with('Role')->find();
    if ($participant === null)
    {
      return true;
    }
    $role = \event\models\Role::model()->findByPk($this->RoleId);
    if (empty($role))
    {
      return false;
    }

    return $participant->Role->Priority < $role->Priority;
  }

  /**
   * @param \user\models\User $user
   * @param array $params
   *
   * @return bool
   */
  public function internalBuyProduct($user, $params = array())
  {
    /** @var $role \event\models\Role */
    $role = \event\models\Role::model()->findByPk($this->RoleId);
    /** @var $event \event\models\Event */
    $event = \event\models\Event::model()->findByPk($this->product->EventId);
    if (empty($event))
    {
      return false;
    }
    $event->registerUser($user, $role);

    return true;
  }

  /** todo: old methods */

  public function rollbackProduct($user)
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
   *
   * @param \user\models\User $fromUser
   * @param \user\models\User $toUser
   * @return bool
   */
  public function redirectProduct($fromUser, $toUser)
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
