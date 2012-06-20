<?php
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');

class PartnerUserEdit extends PartnerCommand
{

  /**
   * Основные действия комманды
   * @param int $rocId
   * @return void
   */
  protected function doExecute($rocId = 0)
  {
    $this->view->HeadScript(array('src'=>'/js/libs/jquery-ui-1.8.16.custom.min.js'));
    $this->view->HeadLink(array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => '/css/blitzer/jquery-ui-1.8.16.custom.css'));
    $this->view->HeadScript(array('src'=>'/js/partner/user.edit.js'));

    $this->SetTitle('Добавление/редактирование участника мероприятия');

    $rocId = intval($rocId);
    $user = User::GetByRocid($rocId);

    $eventUser = null;
    if (!empty($user))
    {
      $eventUser = EventUser::GetByUserEventId($user->UserId, $this->Account->EventId);
    }

    if (Yii::app()->request->getIsPostRequest())
    {
      $roleId = intval(Registry::GetRequestVar('RoleId'));

      if (empty($user))
      {
        $rocId = intval(Registry::GetRequestVar('RocId', 0));
        $user = User::GetByRocid($rocId);
      }

      if (!empty($user))
      {
        $eventUser = EventUser::GetByUserEventId($user->UserId, $this->Account->EventId);

        $event = Event::GetById($this->Account->EventId);
        if ($roleId == 0 && !empty($eventUser))
        {
          $eventUser->delete();
        }
        elseif ($roleId != 0)
        {
          $role = EventRoles::GetById($roleId);
          if (empty($eventUser))
          {
            $eventUser = $event->RegisterUser($user, $role);
          }
          else
          {
            $eventUser->UpdateRole($role);
          }
        }

        Lib::Redirect(RouteRegistry::GetUrl('partner', 'user', 'index') . '?' . http_build_query(array('filter' => array('RocId' => $user->RocId))));
      }
      else
      {
        $this->view->Error = 'Не удалось найти пользователя с rocID ' . $rocId . '. Убедитесь, что все данные указаны правильно.';
      }
    }



    $this->view->EventUser = $eventUser;
    $this->view->User = $user;
    $this->view->Roles = EventRoles::GetAll();

    echo $this->view;
  }
}