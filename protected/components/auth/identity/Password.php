<?php
namespace application\components\auth\identity;

class Password extends \application\components\auth\identity\Base
{
  public function __construct($rocIdOrEmail, $password)
  {
    $this->username = $rocIdOrEmail;
    $this->password = $password;
  }
  
  public function authenticate()
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.Rocid = :RocIdOrEmail OR t.Email = :RocIdOrEmail';
    $criteria->params['RocIdOrEmail'] = $this->username;
    /** @var $user \user\models\User */
    $user = \user\models\User::model()->find($criteria);
    if ($user == null
        || $user->Settings->Visible == 0)
    {
      $this->errorCode = self::ERROR_USERNAME_INVALID;
    }
    else if (!$user->CheckLogin($user->RocId, $this->password))
    {
      $this->errorCode = self::ERROR_PASSWORD_INVALID;
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
