<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 13.09.11
 * Time: 16:51
 * To change this template use File | Settings | File Templates.
 */
 
class FastAuthIdentity extends GeneralIdentity
{
  private $_id;

  /**
	 * @var string
	 */
	public $rocid;

  public function __construct($rocid)
  {
    $this->rocid = $rocid;
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
