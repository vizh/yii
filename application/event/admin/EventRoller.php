<?php

class EventRoller extends AdminCommand
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
    $eventId = intval($eventId);
    $rocId = intval($rocId);
    $roleId = intval($roleId);
    $event = Event::GetById($eventId);
    $user = User::GetByRocid($rocId);
    $role = EventRoles::GetById($roleId);

    if (empty($event))
    {
      echo 'EventId указан не верно';
      return;
    }
    if (empty($user))
    {
      echo 'rocID указан не верно';
      return;
    }
    if (empty($role))
    {
      echo 'RoleId указан не верно';
      return;
    }

    $eventUser = $event->RegisterUser($user, $role);
    if (!empty($eventUser))
    {
      echo 'Создана новая запись в базе. Пользователь ' . $user->LastName . ' ' . $user->FirstName . ' ранее не был зарегистрирован на мероприятие.';
    }
    else
    {
      $eventUser = EventUser::GetByUserEventId($user->UserId, $event->EventId);
      if ($eventUser->RoleId === $role->RoleId)
      {
        echo 'У пользователя ' . $user->LastName . ' ' . $user->FirstName . ' уже выставлена текущая роль на мероприятии';
      }
      else
      {
        $eventUser->UpdateRole($role);
        echo 'Роль пользователя ' . $user->LastName . ' ' . $user->FirstName . ' на мероприятии обновлена.';
      }
    }
  }
}
