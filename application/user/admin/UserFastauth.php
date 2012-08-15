<?php

class UserFastauth extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    if (Yii::app()->getRequest()->getIsPostRequest())
    {
            
      $event = Registry::GetRequestVar('action');
      $rocid = intval(Registry::GetRequestVar('rocid'));

      switch($event) {
        case 'auth':
          self::doAuthAsUser($rocid);
        break;
        case 'link':
          self::getAuthLink($rocid);
        break;
      }

    }
    
    echo $this->view;
  }
  
  private function doAuthAsUser($rocid)
  {
      $identity = new FastAuthIdentity($rocid);
      $identity->authenticate();
      
      if ($identity->errorCode == CUserIdentity::ERROR_NONE)
      {
        Yii::app()->user->login($identity, $identity->GetExpire());
        Lib::Redirect('/');
      }
      else
      {
        $this->view->Error = 'Ошибка авторизации. Возможно пользователя с таким rocID не существует.';
      }
  }
  
  private function getAuthLink($rocid)
  {
    $user = User::GetByRocid($rocid);
      
    if ($user != null)
    {
      $this->view->AuthLink = 'http://' . ROCID_HOST . '/auth/' . $user->RocId . '/' . $user->GetAuthHash() . '/';
    }
  }
  
}
