<?php

class EventUsers extends MobileCommand
{  
  private $event = null;
  
  protected function preExecute()
  {
    parent::preExecute();    
    //Установка хеадера        
    $this->RedirectNonAuth();
    
    $titles = Registry::GetWord('titles'); 
    $this->SetTitle($titles['mobile']);
  }
  
  protected function doExecute($idName = '')
  {
    $this->event = Event::GetEventByIdName($idName, Event::LoadOnlyEvent);
    
    if (empty($this->event))
    {
      throw new Exception('Мероприятие с текстовым идентификатором ' . $idName . ' не обнаружено.');
    }

    $nameSeq = Registry::GetRequestVar('NameSeq');
    $nameSeq = $nameSeq == null ? '' : $nameSeq;
    
    $this->view->IdName = $this->event->GetIdName();
    
    $userList = User::GetUserListByEvent($nameSeq, $this->event->GetEventId());
    $users = $userList['users'];
    $count = $userList['count'];
    
    $userListContainer = new ViewContainer();
    foreach ($users as $user)
    {
      $view = new View();
      $view->SetTemplate('user');
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

    $this->view->NameSeq = $nameSeq;
    $this->view->UserList = $userListContainer;
    
    echo $this->view;
  }  
}