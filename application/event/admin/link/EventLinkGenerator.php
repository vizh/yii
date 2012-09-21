<?php
AutoLoader::Import('library.rocid.event.*');

class EventLinkGenerator extends AdminCommand
{

  /**
   * Основные действия комманды
   * @param int $eventId
   * @param int $rocId
   * @param int $roleId
   * @return void
   */
  protected function doExecute($eventId = 0, $rocId = 0, $roleId = 0)
  {
    $event = Event::GetById($eventId);
    if (empty($event))
    {
      echo 'Не верно задан id мероприятия!';
      return;
    }
    $user = User::GetByRocid($rocId);
    if (empty($user))
    {
      echo 'Не верно задан rocId пользователя';
      return;
    }
    $role = EventRoles::GetById($roleId);
    if (empty($role))
    {
      echo 'Не верно задан id роли';
      return;
    }

    echo $event->getRegisterUrl($rocId, $roleId);
  }
}
