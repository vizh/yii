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
  protected function doExecute($rocId = 0, $code = '')
  {
    $eventNameId = 'gm2012';//Registry::GetRequestVar('proj');
    //$userId = intval(Registry::GetRequestVar('id'));
    //$code = Registry::GetRequestVar('code');
    $rocId = intval($rocId);


    if ($code == EventWidgetGetlink::GetCode($rocId))
    {
      $user = User::GetByRocid($rocId);
      $event = Event::GetEventByIdName($eventNameId);
      $role = EventRoles::GetById(1);
      if (!empty($event) && !empty($user))
      {
        $eventUser = $event->RegisterUser($user, $role);
        if (!empty($eventUser))
        {
          $this->view->Name = $event->Name;
          //$this->view->HeadMeta(array('http-equiv' => 'refresh', 'content' => '5;http://raec.ru/about/meetings/2012/?FIRST'));
          $this->view->HeadMeta(array('http-equiv' => 'refresh', 'content' => '5;http://rocid.ru/events/gm2012/'));
          echo $this->view;
        }
        else
        {
          //Lib::Redirect('http://raec.ru/about/meetings/2012/?EXIST');
          Lib::Redirect('http://rocid.ru/events/gm2012/');
        }
      }
    }
    else
    {
      echo 'Ошибка регистрации: не верный ключ';
    }
  }
}
