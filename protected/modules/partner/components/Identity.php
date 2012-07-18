<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 17.05.12
 * Time: 14:24
 * To change this template use File | Settings | File Templates.
 */
class Identity extends CUserIdentity
{
  private $_id;


  public function authenticate()
  {
    /** @var $partner PartnerAccount */
    $partner = PartnerAccount::model()->find('t.Login = :Login', array(':Login' => $this->username));

    if ($partner === null)
    {
      $this->errorCode = self::ERROR_USERNAME_INVALID;
    }
    elseif ($partner->GetHash($this->password) !== $partner->Password)
    {
      $this->errorCode=self::ERROR_PASSWORD_INVALID;
    }
    else
    {
      $this->_id = $partner->AccountId;
      $this->errorCode=self::ERROR_NONE;
    }
    return $this->errorCode==self::ERROR_NONE;
  }

  public function getId()
  {
    return $this->_id;
  }
}
