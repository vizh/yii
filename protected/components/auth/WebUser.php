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
      $this->_currentUser = \application\models\user\User::GetById($this->getId());
    }

    return $this->_currentUser;
  }
}
