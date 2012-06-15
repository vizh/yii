<?php
AutoLoader::Import('library.rocid.company.*');

class MainRecovery extends MobileCommand
{  
  private $event = null;
  
  protected function preExecute()
  {
    parent::preExecute();    
    //Установка хеадера        
    
    $titles = Registry::GetWord('titles'); 
    $this->SetTitle($titles['mobile']);
  }
  
  protected function doExecute()
  {         
    $formid = Registry::GetRequestVar('formid');
    if ($formid != null)
    {
      $rocid = Registry::GetRequestVar('rocid');
      $email = Registry::GetRequestVar('email');
      
      $isSuccess = false;
      
      $user = User::LoadUserByRocid($rocid);
      if ($user != null)
      {
        $userEmail = $user->GetEmail();        
        if ($userEmail != null && $userEmail->Email == $email)
        {
          $isSuccess = true;
        }
      }
      
      if ($isSuccess)
      {
        $this->view->SetTemplate('success');
        $mobilePassword = $user->GetMobilePassword();
        if ($mobilePassword == null)
        {
          $mobilePassword = new UserMobilePassword();
          $mobilePassword->UserId = $user->GetUserId();
          $mobilePassword->ExpireTime = 0;
        }
        
        if ($mobilePassword->ExpireTime < time())
        {
          $mobilePassword->Password = $this->GeneratePassword();
          $date = getdate(time());
          $mobilePassword->ExpireTime = mktime(0, 0, 0, $date['mon'], $date['mday']+1, $date['year']);
          $mobilePassword->save();
        }
        $this->view->Password = $mobilePassword->Password;
      }
      else
      {
        $this->view->SetTemplate('failure');
      }
    }
    
    echo $this->view;
  }
  
  /**
  * Временный пароль
  * @return string
  */  
  private function GeneratePassword()
  {
    $password = '';
    $length = mt_rand(4,5);
    for ($i = 0; $i < $length; $i++)
    {
      $password .= mt_rand(0, 9);
    }
    
    return $password;
  }
}

