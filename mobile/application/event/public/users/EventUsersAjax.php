<?php
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');

class EventUsersAjax extends AjaxNonAuthCommand
{  
  private $event = null;

  protected function preExecute()
  {
    parent::preExecute();

    $this->view->SetLayout('main');
    $this->view->UseLayout(true);
  }
  
  protected function doExecute($idName = '')
  {
    $this->event = Event::GetEventByIdName($idName, Event::LoadOnlyEvent);
    
    $nameSeq = Registry::GetRequestVar('NameSeq');
    $nameSeq = $nameSeq == null ? '' : $nameSeq;
    
    if (empty($this->event))
    {
      throw new Exception('Мероприятие с текстовым идентификатором ' . $idName . ' не обнаружено.');
    }    
    
    $userList = User::GetUserListByEvent($nameSeq, $this->event->GetEventId());
    $users = $userList['users'];
    $count = $userList['count'];
    
    $userListContainer = new ViewContainer();
    foreach ($users as $user)
    {
      $view = new View();
      $view->SetTemplate('user', 'event', 'users', '');
      $view->RocId = $user->GetRocId();
      $view->LastName = $user->GetLastName();
      $view->FirstName = $user->GetFirstName();
      
      $employments = $user->GetEmployments();
      foreach ($employments as $employment)
      {
        if ($employment->Primary == 1)
        {
          $company = $employment->GetCompany();
          if (! empty($company))
          {
            $view->CompanyId = $company->CompanyId;
            $view->CompanyName = $company->FullName;
          }
          else
          {
            Lib::log('Message: Empty Company, but no empty employment.  Trace string: getUsersHtml in application/user/UserList.php ', CLogger::LEVEL_ERROR, 'application');
          }   
          break;
        }
      }
      
      
      $userListContainer->AddView($view);
    }
    
    $this->view->UserList = $userListContainer;

    //$result['data'] = $this->view->__toString();
    //echo json_encode($result);
    echo $this->view;
  }  
}