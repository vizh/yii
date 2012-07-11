<?php
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.event.*');

class EventRegisteronday extends ApiCommand
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

    $day = EventDay::model()->findByPk($dayId);
    if (empty($day))
    {
      throw new ApiException(306, array($day));
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


    $eventUser = $event->RegisterUserOnDay($day, $user, $role);
    if (empty($eventUser))
    {
      throw new ApiException(307);
    }
    $this->SendJson(array('Success' => true));
  }
}
