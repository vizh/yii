<?php
AutoLoader::Import('gate.source.*');
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');

/**
 * Запрос отправляется методом _GET или _POST, должен содержать следующие
 * обязательные параметры:
 *   &event=[ID мероприятия в системе rocID]
 *   &rocid=[rocID пользователя]
 *   &token=[Уникальный ключ операции]
 *
 * Сервер возвращает ответ в XML-формате, ответ содержит код возможной ошибки:
 *   0   - Операция прошла успешно, регистрация пользователя удалена
 *   101 - Некорректный уникальный ключ
 *   102 - Мероприятия с указанным ID не существует
 *   201 - Неправильный (несуществующий) rocID
 *   203 - Пользователь не зарегистрирован на мероприятие
 *
 */
 
class GateRegistrationDelete extends GateCommand
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
    $rocid = intval(Registry::GetRequestVar('rocid', 0));

    $event = Event::GetEventByIdName($this->EventName);
    // Проверка корректности мероприятия
    if (empty($event))
    {
      $this->SendResponse(102);
    }

    // Полние информации о пользователе
    //$user = getUserInfo($rocid);
    $user = User::GetByRocid($rocid);

    if (empty($user))
    {
      $this->SendResponse(201);
    }

    $eventUser = EventUser::GetByUserEventId($user->UserId, $event->EventId);

    if (empty($eventUser))
    {
       $this->SendResponse(203);
    }
    else
    {
      $eventUser->delete();
      $this->SendResponse(0);
    }
  }
}
