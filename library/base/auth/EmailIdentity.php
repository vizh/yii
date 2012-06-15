<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 21.06.11
 * Time: 18:07
 * To change this template use File | Settings | File Templates.
 */

class EmailIdentity extends GeneralIdentity
{
  private $_id;

  /**
   * @var string
   */
	public $email;

  public function __construct($email, $password)
  {
    $this->email = $email;
		$this->password = $password;
  }

  public function authenticate()
  {
    $user = User::GetByEmail($this->email);

    if ($user === null || $user->Settings->Visible == 0)
    {
      $this->errorCode = self::ERROR_USERNAME_INVALID;
    }
    elseif (!$user->CheckLogin($user->RocId, $this->password))
    {
      $this->errorCode=self::ERROR_PASSWORD_INVALID;
    }
    else
    {
      $this->_id = $user->UserId;
      $this->errorCode=self::ERROR_NONE;
      $user->CreateSecretKey();
    }
    return $this->errorCode==self::ERROR_NONE;
  }

  public function getId()
  {
    return $this->_id;
  }
}
