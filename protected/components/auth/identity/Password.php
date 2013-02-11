<?php
namespace application\components\auth\identity;

class Password extends \application\components\auth\identity\Base
{
  public function __construct($login, $password)
  {
    $this->username = $login;
    $this->password = $password;
  }
  
  public function authenticate()
  {
    /** @var $user \user\models\User */
    $user = \user\models\User::model()
        ->byRunetId(intval($this->username))
        ->byEmail($this->username, false)->find();
    if ($user === null)
    {
      $this->errorCode = self::ERROR_USERNAME_INVALID;
    }
    else if (!$user->checkLogin($this->password))
    {
      $this->errorCode = self::ERROR_PASSWORD_INVALID;
    }
    else
    {
      $this->_id = $user->Id;
      $this->errorCode = self::ERROR_NONE;
    }
    return $this->errorCode == self::ERROR_NONE;
  }
}
