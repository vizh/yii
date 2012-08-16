<?php
AutoLoader::Import('library.rocid.user.*');

class MainFastauth extends AbstractCommand
{
  protected function doExecute($rocid = null, $hash = null)
  { 
    $user = User::GetByRocid($rocid);
    
    if ($user != null)
    {
      if ($hash == $user->GetAuthHash())
      {
        $identity = new FastAuthIdentity($rocid);
        $identity->authenticate();
        if ($identity->errorCode == CUserIdentity::ERROR_NONE)
        {
          Yii::app()->user->login($identity, $identity->GetExpire());
          Lib::Redirect(
            RouteRegistry::GetUrl('user', '', 'show', array('rocid' => $user->RocId))
          );
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
