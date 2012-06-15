<?php
AutoLoader::Import('library.rocid.user.User');

abstract class GeneralCommand extends AuthCommand
{
  
  
  protected function preExecute()
  {
    parent::preExecute();    
    
    header('Content-Type: text/html; charset=utf-8');
    $this->view->SetLayout('main');

    $this->view->UserBar = new UserBar();
    $titles = Registry::GetWord('titles'); 
    $this->SetTitle($titles['general']);
    $this->view->Banner = $this->getBanner();

    if (! empty($this->LoginUser))
    {
      $this->checkLoginUser();
      $this->LoginUser->UpdateLastVisit();
    }
  }
  
  protected function postExecute()
  {
    if ($_SERVER['HTTP_HOST'] == 'beta.rocid' || (!empty($this->LoginUser) && $this->LoginUser->RocId == 35287))
    {
      $logger = Yii::getLogger();
      $stats = Yii::app()->db->getStats();

      echo '<br/> SQL queries: ' . $stats[0] .
          '<br/> SQL Execution Time: ' . $stats[1] .
        '<br/> Full Execution Time: ' . $logger->getExecutionTime();

      $logs = $logger->getProfilingResults();

      echo '<pre>';
      print_r($logs);
      echo '</pre>';
    }
  }

  private function checkLoginUser()
  {
    if ($this->LoginUser->Settings->Agreement == 0)
    {
      $this->SendAgreementAndExit();
    }
    if ((empty($this->LoginUser->LastName) || empty($this->LoginUser->FirstName)) &&
        RouteRegistry::GetInstance()->GetCommand() == 'edit' && RouteRegistry::GetInstance()->GetModule() != 'user')
    {
      Lib::Redirect('/user/edit/');
    }
  }



  protected function SendAgreementAndExit()
  {
    if (Yii::app()->getRequest()->getIsPostRequest())
    {
      $route = RouteRegistry::GetInstance();
      $redirectUrl = RouteRegistry::GetUrl($route->GetModule(), $route->GetSection(), $route->GetCommand(), $route->GetParams());
      $cancel = Registry::GetRequestVar('cancel');
      if ($cancel == 1)
      {
        Yii::app()->user->logout();
        Cookie::Clear();
        $this->LoginUser = null;
        Lib::Redirect($redirectUrl);
      }

      $agree = Registry::GetRequestVar('agree', false);
      if ($agree !== false)
      {
        $this->LoginUser->Settings->ApplyAgree();
        Lib::Redirect($redirectUrl);
      }
      else
      {
        $this->AddErrorNotice('Необходимо выбрать "Я принимаю пользовательское соглашение" для продолжения работы с rocID.');
      }
    }
    $this->view->SetTemplate('agreement', 'core', 'agreement', '', 'public');

    $textView = new View();
    $textView->SetTemplate('text', 'core', 'agreement', '', 'public');
    $this->view->Text = $textView;
    echo $this->view;
    exit;
  }
}