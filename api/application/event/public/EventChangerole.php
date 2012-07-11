<?php
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.event.*');

class EventChangerole extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $rocId = Registry::GetRequestVar('RocId');
    $roleId = Registry::GetRequestVar('RoleId');
    $dayId = Registry::GetRequestVar('DayId');

    $event = Event::GetById($this->Account->EventId);
    if (empty($event))
    {
      throw new ApiException(301);
    }

    if (!empty($dayId) && empty($event->Days))
    {
      throw new ApiException(308);
    }
    elseif (empty($dayId) && !empty($event->Days))
    {
      throw new ApiException(309);
    }

    $user = User::GetByRocid($rocId);
    if (empty($user))
    {
      throw new ApiException(202, array($rocId));
    }

    $role = EventRoles::GetById($roleId);
    if (empty($role))
    {
      throw new ApiException(302);
    }

    /** @var $day EventDay */
    $day = EventDay::model()->findByPk($dayId);
    if (!empty($dayId) && empty($day))
    {
      throw new ApiException(306, array($day));
    }

    $eventUser = EventUser::model()->byEventId($event->EventId)->byUserId($user->UserId);
    if (!empty($day))
    {
      $eventUser->byDayId($day->DayId);
    }
    else
    {
      $eventUser->byDayNull();
    }
    $eventUser = $eventUser->find();
    if (empty($eventUser))
    {
      throw new ApiException(304);
    }
    if ($eventUser->RoleId == $role->RoleId)
    {
      throw new ApiException(305);
    }

    $eventUser->UpdateRole($role);

    $this->SendJson(array('Success' => true));
  }
}