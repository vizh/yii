<?php
AutoLoader::Import('event.public.widget.EventWidgetGetlink');
AutoLoader::Import('library.rocid.event.*');
 
class EventWidgetQuick extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @param int $userId
   * @param string $code
   * @return void
   */
  protected function doExecute($userId = 0, $code = '')
  {
    $eventNameId = 'gm2011';//Registry::GetRequestVar('proj');
    //$userId = intval(Registry::GetRequestVar('id'));
    //$code = Registry::GetRequestVar('code');
    $userId = intval($userId);

    if ($code == EventWidgetGetlink::GetCode($userId))
    {
      $event = Event::GetEventByIdName($eventNameId);
      if (! empty($event))
      {
        $eventUser = $event->RegisterUser($userId, 1);
        if (!empty($eventUser))
        {
          Lib::Redirect('http://raec.ru/about/meetings/2011/?FIRST');
        }
        else
        {
          Lib::Redirect('http://raec.ru/about/meetings/2011/?EXIST');
        }
      }
    }
    else
    {
      echo 'Ошибка регистрации: не верный ключ';
    }
  }
}
