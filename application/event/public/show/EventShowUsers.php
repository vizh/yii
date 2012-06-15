<?php
AutoLoader::Import('library.rocid.event.*');

class EventShowUsers extends GeneralCommand
{

  /** @var Event */
  private $event;

  /**
   * Основные действия комманды
   * @param string $idName
   * @return void
   */
  protected function doExecute($idName = '')
  {
    $this->event = Event::GetEventByIdName($idName);

    if (empty($this->event))
    {
      Lib::Redirect('/events/');
    }

    $titles = Registry::GetWord('titles');
    $this->SetTitle($titles['eventusers'] . ' - ' . $this->event->GetName());

    $this->view->Name = $this->event->GetName();
    $this->view->IdName = $this->event->IdName;

    $searchQuery = Registry::GetRequestVar('q');

    if (mb_check_encoding($searchQuery, 'windows-1251') && ! mb_check_encoding($searchQuery, 'utf-8'))
    {
      $searchQuery = mb_convert_encoding($searchQuery, 'utf-8', 'windows-1251');
    }
    $searchQuery = trim($searchQuery);


    $this->view->Query = $searchQuery;
    $searchQuery = mb_strtolower($searchQuery, 'utf-8');

    $searchPage = Registry::GetRequestVar('p');
    $searchPage = intval($searchPage);
    $searchPage = $searchPage < 1 ? 1 : $searchPage;

    $userList = User::GetUserListByEvent($searchQuery, $this->event->GetEventId(), $searchPage);
    $users = $userList['users'];
    $count = $userList['count'];

    $this->view->Count = $count;
    $this->view->Users = $this->getUsersHtml($users);

    $resultsPerPage = SettingManager::GetSetting('UserPerPage');
    $url = '/events/users/' . $this->event->IdName .'/?p=%s';
    $this->view->Paginator = new Paginator($url, $searchPage, $resultsPerPage,
      $count, array('q'=>$searchQuery));

    echo $this->view;
  }

  /**
   * @param User[] $users
   * @return string
   */
  private function getUsersHtml($users)
  {
    if (! empty($users))
    {
      $container = new ViewContainer();
      $flag = false;
      foreach ($users as $user)
      {
        $view = new View();
        $view->SetTemplate('user');

        $view->RocId = $user->GetRocId();
        $view->LastName = $user->GetLastName();
        $view->FirstName = $user->GetFirstName();
        $view->Photo = $user->GetMiniPhoto();

        $employment = $user->EmploymentPrimary();
        if (! empty($employment) && !empty($employment->Company))
        {
          $view->CompanyId = $employment->Company->CompanyId;
          $view->CompanyName = $employment->Company->GetName();
        }

        $container->AddView($view);
        if ($flag)
        {
          $empty = new View();
          $empty->SetTemplate('user');
          $empty->Empty = true;
          $container->AddView($empty);
          $flag = false;
        }
        else
        {
          $flag = true;
        }
      }

      return $container;
    }

    return '';
  }
}
 
