<?php
AutoLoader::Import('gate.source.*');
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');

/**
 * Запрос отправляется методом _GET или _POST, должен содержать следующие
 * обязательные параметры:
 *   &event=[ID мероприятия в системе rocID]
 *   &role=[ID типа участия в мероприятии] (необязательно)
 *   &rocid=[rocID пользователя]
 *   &passw=[MD5-хэш пароля пользователя]
 *   &token=[Уникальный ключ операции]
 *
 * Сервер возвращает ответ в XML-формате, ответ содержит код возможной ошибки:
 *   0   - Операция прошла успешно, пользователь зарегистрирован
 *   101 - Некорректный уникальный ключ
 *   102 - Мероприятия с указанным ID не существует
 *   201 - Неправильный (несуществующий) rocID
 *   202 - Неправильный пароль (MD5-хэш пароля) пользователя
 *   203 - Полователь уже зарегистрирован на мероприятие
 *
 */

class GateRegistration extends GateCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    /**
     * Принимаемые данные
     */
    $role_id = intval(Registry::GetRequestVar('role', 1));
    $rocid = intval(Registry::GetRequestVar('rocid', 0));
    $passw = Registry::GetRequestVar('passw');
    $reset = intval(Registry::GetRequestVar('reset', 0));

    $event = Event::GetEventByIdName($this->EventName);
    // Проверка корректности мероприятия
    if (empty($event))
    {
      $this->SendResponse(102);
    };

    // Полние информации о пользователе
    //$user = getUserInfo($rocid);
    $user = User::GetByRocid($rocid);

    if (empty($user))
    {
      $this->SendResponse(201);
    }
//    elseif ($user->Password != $passw)
//    {
//      $this->SendResponse(202);
//    }

    $eventUser = EventUser::GetByUserEventId($user->UserId, $event->EventId);
    $approve = 0;
    if ($reset && ! empty($eventUser))
    {
      $approve = $eventUser->Approve;
      $eventUser->delete();
      $eventUser = null;
    }

    // Зарегистрирован ли на мероприятие?

    if (empty($eventUser))
    {
      $eventUser = new EventUser();
      $eventUser->EventId = $event->EventId;
      $eventUser->UserId = $user->UserId;
      $eventUser->RoleId = $role_id;
      $eventUser->Approve = $approve;
      $eventUser->CreationTime = $eventUser->UpdateTime = time();
      $eventUser->save();

      $email = $user->GetEmail() != null ? $user->GetEmail()->Email : $user->Email;

      $result = array('user_id' => $user->UserId, 'rocid' => $user->RocId, 'lastname' => iconv('utf-8', 'cp1251', $user->LastName), 'firstname' => iconv('utf-8', 'cp1251', $user->FirstName), 'email' => $email);

      foreach ($user->Employments as $employment)
      {
        if ($employment->Primary == 1 && ! empty($employment->Company))
        {
          $result['company'] = iconv('utf-8', 'cp1251', $employment->Company->Name);
          break;
        }
      }

      $this->SendResponse(0, array($result));
    }
    else
    {
      $this->SendResponse(203);
    }
  }
}