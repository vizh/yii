<?php
namespace application\components\auth\identity;

class Runetid extends \application\components\auth\identity\Base
{

  public function __construct($rocid)
  {
    $this->username = intval($rocid);
  }

  public function authenticate()
  {
    $user = \user\models\User::GetByRocid($this->username);

    if ($user === null || $user->Settings->Visible == 0)
    {
      $this->errorCode = self::ERROR_USERNAME_INVALID;
    }
    else
    {
      $this->_id = $user->UserId;
      $this->errorCode = self::ERROR_NONE;
      $user->CreateSecretKey();
    }
    return $this->errorCode == self::ERROR_NONE;
  }
}
