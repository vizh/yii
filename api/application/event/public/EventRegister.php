<?php
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.event.*');

class EventRegister extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $rocId = Registry::GetRequestVar('RocId');
    $roleId = Registry::GetRequestVar('RoleId');

    $event = Event::GetById($this->Account->EventId);
    if (empty($event))
    {
      throw new ApiException(301);
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

    $eventUser = $event->RegisterUser($user, $role);
    if (empty($eventUser))
    {
      throw new ApiException(303);
    }

    $this->SendJson(array('Success' => true));
  }
}
