<?php
AutoLoader::Import('library.rocid.user.*');

class MainFastauth extends AbstractCommand
{
  
  protected function doExecute($rocid = null, $hash = null)
  {
    
    $rocId = intval(Registry::GetRequestVar('rocid'));
    $user = User::GetByRocid($rocId);
    
    if ($user != null)
    {
      $hashCheck = $user->GetAuthHash();
      
      if ($hash == $hashCheck)
      {
        $identity = new FastAuthIdentity($rocId);
        $identity->authenticate();
        if ($identity->errorCode == CUserIdentity::ERROR_NONE)
        {
          Yii::app()->user->login($identity, $identity->GetExpire());
          Lib::Redirect('http://' . ROCID_HOST . '/' . $rocId . '/');
        }
        else
        {
          $this->Send404AndExit();
        }
      }
      else
      {
        $this->Send404AndExit();
      }
    }
   
  }
}
