<?php
AutoLoader::Import('event.public.widget.EventWidgetGetlink');
AutoLoader::Import('library.rocid.event.*');
 
class EventWidgetQuick extends GeneralCommand
{
  private $roles = array(6,32,33);
  /**
   * Основные действия комманды
   * @param int $userId
   * @param string $code
   * @return void
   */
  protected function doExecute($rocId = 0, $roleId = 0, $code = '')
  {
    $eventNameId = 'gm2012';//Registry::GetRequestVar('proj');
    //$userId = intval(Registry::GetRequestVar('id'));
    //$code = Registry::GetRequestVar('code');
    $rocId = intval($rocId);
    $roleId = intval($roleId);

    if ($code == EventWidgetGetlink::GetCode($rocId))
    {
      $user = User::GetByRocid($rocId);
      $event = Event::GetEventByIdName($eventNameId);
      $role = EventRoles::GetById($roleId);
      if (!empty($event) && !empty($user) && !empty($role) && in_array($roleId, $this->roles))
      {
        $eventUser = $event->RegisterUser($user, $role);
        if (!empty($eventUser))
        {
          $this->view->Name = $event->Name;
          //$this->view->HeadMeta(array('http-equiv' => 'refresh', 'content' => '5;http://raec.ru/about/meetings/2012/?FIRST'));
//          $this->view->HeadMeta(array('http-equiv' => 'refresh', 'content' => '5;http://rocid.ru/events/gm2012/'));
          $this->view->HeadMeta(array('http-equiv' => 'refresh', 'content' => '5;http://www.raec.ru/about/meetings/1652/'));
          echo $this->view;
        }
        else
        {
          //Lib::Redirect('http://raec.ru/about/meetings/2012/?EXIST');
//          Lib::Redirect('http://rocid.ru/events/gm2012/');
          Lib::Redirect('http://www.raec.ru/about/meetings/1652/');
        }
      }
      else
      {
        echo 'Ошибка регистрации: неверные параметры';
      }
    }
    else
    {
      echo 'Ошибка регистрации: неверный ключ';
    }
  }
}
