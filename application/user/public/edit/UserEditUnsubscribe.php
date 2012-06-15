<?php

class UserEditUnsubscribe extends GeneralCommand
{
  const SecretKey = 'qnpvoztjfuuavcfrzwadsmsjn';

  /**
   * Основные действия комманды
   * @param int $rocid
   * @param string $hash
   * @return void
   */
  protected function doExecute($rocid = 0, $hash = '')
  {
    $hashCheck = substr(md5($rocid.self::SecretKey), 0, 16);
    if ($hash == $hashCheck)
    {
      $user = User::GetByRocid($rocid);
      $user->Settings->ProjNews = 0;
      $user->Settings->save();
    }
    else
    {
      $this->view->SetTemplate('error');
    }
    echo $this->view;
  }
}
