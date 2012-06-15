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
      $rocid = intval(Registry::GetRequestVar('rocid'));
      $identity = new FastAuthIdentity($rocid);
      $identity->authenticate();
      if ($identity->errorCode == CUserIdentity::ERROR_NONE)
      {
        //Yii::app()->user->logout();
        Yii::app()->user->login($identity, $identity->GetExpire());
        Lib::Redirect('/');
      }
      else
      {
        $this->view->Error = 'Ошибка авторизации. Возможно пользователя с таким rocID не существует.';
      }

    }
    echo $this->view;
  }
}
