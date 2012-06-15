<?php

class MainAuth extends PayCommand
{
  private static $secretKey = 'qJVRiqsIvOkZvmrq';

  /**
   * Основные действия комманды
   * @param int $eventId
   * @param int $rocId
   * @return void
   */
  protected function doExecute($eventId = 0, $rocId = 0)
  {
    //if (!$this->checkHash($rocId, $hash))
    //{
      //$this->view->SetTemplate('no-user');
      //echo $this->view;
      //return;
      //todo: Раскомментить текст... А нужно ли? И зачем тут хэш? ...
    //}

    $user = User::GetByRocid($rocId);
    if (empty($user))
    {
      $this->view->SetTemplate('no-user');
      echo $this->view;
      return;
    }
    
    if (Yii::app()->getRequest()->getIsPostRequest())
    {
      $password = Registry::GetRequestVar('password');
      $identity = new RocidIdentity($user->RocId, $password);
      $identity->authenticate();
      if ($identity->errorCode == CUserIdentity::ERROR_NONE)
      {
        Yii::app()->user->login($identity, $identity->GetExpire());
        Lib::Redirect(RouteRegistry::GetUrl('main', '', 'index', array('eventId' => $eventId)));
      }
      else
      {
        $this->AddErrorNotice('Неверно введен пароль!', 'Авторизоваться не удалось');
      }
    }

    if ($this->LoginUser !== null && $this->LoginUser->RocId == $rocId)
    {
      Lib::Redirect(RouteRegistry::GetUrl('main', '', 'index', array('eventId' => $eventId)));
    }
    else
    {
      if ($this->LoginUser !== null)
      {
        Yii::app()->user->logout();
      }
      $this->view->User = $user;
    }

    echo $this->view;
  }

//  private function checkHash($rocId, $hash)
//  {
//    return $hash === $this->getHash($rocId);
//  }
//
//  private function getHash($rocId)
//  {
//    return substr(md5($rocId.self::$secretKey), 0, 16);
//  }
}
