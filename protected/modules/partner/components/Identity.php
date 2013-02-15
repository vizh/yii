<?php
namespace partner\components;

class Identity extends \CUserIdentity
{
  private $_id;


  public function authenticate()
  {
    /** @var $account \partner\models\Account */
    $account = \partner\models\Account::model()->find('"t"."Login" = :Login', array(':Login' => $this->username));
    
    if ($account === null)
    {
      $this->errorCode = self::ERROR_USERNAME_INVALID;
    }
    elseif ($account->getHash($this->password) !== $account->Password)
    {
      $this->errorCode=self::ERROR_PASSWORD_INVALID;
    }
    else
    {
      $this->_id = $account->Id;
      $this->errorCode=self::ERROR_NONE;
    }
    return $this->errorCode==self::ERROR_NONE;
  }

  public function getId()
  {
    return $this->_id;
  }
}
