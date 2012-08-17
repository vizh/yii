<?php

class EventWidgetGetlink extends GeneralCommand
{
  const SecretKey = '131f6492c4a806a9';
  const Code = 'zcoW8EhqXa';

  private $roles = array(6,32,33);

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($code = '')
  {
    if ($code == self::Code)
    {
      $rocid = intval(Registry::GetRequestVar('rocid'));
      $roleId = intval(Registry::GetRequestVar('role'));
      $eventNameId = Registry::GetRequestVar('proj');
      $user = User::GetByRocid($rocid);
      if (! empty($user) && ! empty($eventNameId) && ! empty($roleId) && in_array($roleId, $this->roles))
      {
        echo 'http://' . ROCID_HOST . '/' . $eventNameId . '/' . $user->RocId . '/' . $roleId .'/'. self::GetCode($user->RocId);
      }
      else
      {
        echo 'Один из параметров задан не верно';
      }
    }
    else
    {
      echo 'Не верный ключ доступа.';
    }

  }

  public static function GetCode($rocId)
  {
    return substr(md5($rocId . self::SecretKey), 0, 16);
  }
}
