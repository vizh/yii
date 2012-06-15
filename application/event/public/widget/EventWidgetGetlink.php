<?php

class EventWidgetGetlink extends GeneralCommand
{
  const SecretKey = '131f6492c4a806a9';

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $rocid = intval(Registry::GetRequestVar('rocid'));
    $eventNameId = Registry::GetRequestVar('proj');
    $user = User::GetByRocid($rocid);
    if (! empty($user) && ! empty($eventNameId))
    {
      echo 'http://' . $_SERVER['HTTP_HOST'] . '/' . $eventNameId . '/' . $user->UserId . '/' . self::GetCode($user->UserId);
    }
    else
    {
      echo 'Один из параметров задан не верно';
    }
  }

  public static function GetCode($userId)
  {
    return substr(md5($userId . self::SecretKey), 0, 16);
  }
}
