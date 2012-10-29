<?php
namespace application\components\auth;

class WebUser extends \CWebUser {
  private $_currentUser = null;

  /**
   * @return \application\models\user\User
   */
  public function CurrentUser()
  {
    if (!$this->isGuest && $this->_currentUser === null)
    {
      $this->_currentUser = \user\models\User::GetById($this->getId());
    }

    return $this->_currentUser;
  }
  
  private $_keyPrefix = null;
  public function getStateKeyPrefix()
  {
    if($this->_keyPrefix!==null)
      return $this->_keyPrefix;
    else
    {
      $this->_keyPrefix=md5('Yii.CWebUser.'.\Yii::app()->getId());
      return $this->_keyPrefix;
    }
  }
}
