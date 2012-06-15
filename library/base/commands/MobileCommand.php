<?php
AutoLoader::Import('library.rocid.user.User');

abstract class MobileCommand extends AuthCommand
{  
  protected function preExecute()
  {
    parent::preExecute();
    
    header('Content-Type: text/html; charset=utf-8');    
    
//    if ($this->LoginUser === null)
//    {
//      $this->LoginUser = User::GetMobileLoginUser();
//      Registry::SetVariable('LoginUser', $this->LoginUser);
//    }
    
    if ($this->LoginUser === null)
    {        
      $this->fillNonAuthLayout();      
    }
    else
    {
      $this->fillAuthLayout();
    }
    
    $this->view->SetLayout('main');    
  }
  
  protected function postExecute()
  {
    if ($_SERVER['HTTP_HOST'] == 'beta.rocid')
    {
      $logger = Lib::GetLogger();
      $logs = $logger->getLogs();//('', 'system.db.CDbCommand');
      echo '<pre>';
      print_r($logs);
      echo '</pre>';

      echo '<br/> SQL queries: ' . CLogger::GetSQLCounter() . 
        ' Full Execution Time: ' . CLogger::GetExecutionTime();
    }
  }
  
  protected function fillAuthLayout()
  {
    $view = new View();
    $view->SetTemplate('userbar', 'core', 'general', '', 'public');
    
    $rocId = $this->LoginUser->GetRocId();   
        
        
    $view->RocId = $rocId;
    $view->Photo = $this->LoginUser->GetMiniPhoto();
    
    $view->FirstName = $this->LoginUser->GetFirstName();
    $view->FartherName = $this->LoginUser->GetFatherName();
    $view->LastName = $this->LoginUser->GetLastName();
    
    $this->view->UserBar = $view;
  }
  
  protected function fillNonAuthLayout()
  {
    $this->view->UserBar = '';
  }
  
  protected function RedirectNonAuth()
  {
    if ($this->LoginUser === null)
    {
      $host = 'http://' . $_SERVER['HTTP_HOST'];
      Lib::Redirect($host);  
    }      
  }
}
