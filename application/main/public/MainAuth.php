<?php
AutoLoader::Import('library.social.*');
AutoLoader::Import('library.rocid.user.*');

class MainAuth extends AbstractCommand
{
  protected function preExecute()
  {
    parent::preExecute();    
  }
  
  protected function doExecute($service = '')
  {
    if ($service == 'twitter')
    {
      $content = RocidTwitterOAuth::GetContent();
      if ($content)
      {
        $id = $content->id;

        $identity = new TwitterIdentity($id);
        $identity->authenticate();
        if ($identity->errorCode == CUserIdentity::ERROR_NONE)
				{
          Yii::app()->user->login($identity, $identity->GetExpire());
        }
      }
      echo RocidTwitterOAuth::GetResultHtml();
    }
    elseif ($service == 'facebook')
    {
      $call = Registry::GetRequestVar('call');
      $call = !empty($call) ? $call : '/';

      $uid = RocidFacebook::GetUserId();
      if (! empty($uid))
      {

        $identity = new FacebookIdentity($uid);
        $identity->authenticate();
        if ($identity->errorCode == CUserIdentity::ERROR_NONE)
				{
          Yii::app()->user->login($identity, $identity->GetExpire());
          Lib::Redirect($call);
        }
      }
      Lib::Redirect($call . '?error=fb_fail');
    }
  }
}
