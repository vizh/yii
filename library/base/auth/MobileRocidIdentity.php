<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 21.06.11
 * Time: 18:08
 * To change this template use File | Settings | File Templates.
 */
 
class RocidIdentity extends GeneralIdentity
{
  private $_id;

  /**
	 * @var string email
	 */
	public $rocid;

  public function __construct($rocid, $password)
  {
    $this->rocid = intval($rocid);
		$this->password = $password;
  }

  public function authenticate()
  {
    $user = User::GetByRocid($this->rocid);

    if ($user === null || $user->Settings->Visible == 0)
    {
      $this->errorCode = self::ERROR_USERNAME_INVALID;
    }
    else
    {
      $mobilePassword = $user->GetMobilePassword();
      if ($user->CheckLogin($user->RocId, $this->password) ||
          ($mobilePassword && $mobilePassword->ExpireTime > time() &&
           $mobilePassword->Password == $this->password))
      {
        $this->_id = $user->UserId;
        $this->errorCode=self::ERROR_NONE;
        $user->CreateSecretKey();
      }
      else
      {
        $this->errorCode=self::ERROR_PASSWORD_INVALID;
      }
    }
    return $this->errorCode == self::ERROR_NONE;
  }

  public function getId()
  {
    return $this->_id;
  }
}
