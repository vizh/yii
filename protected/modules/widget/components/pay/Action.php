<?php
namespace widget\components\pay;

class Action extends \widget\components\Action
{
  /**
   * @return \user\models\User
   */
  public function getUser()
  {
    return $this->getController()->getUser();
  }

  /**
   * @return \pay\models\Account
   * @throws Exception
   */
  public function getAccount()
  {
    return $this->getController()->getAccount();
  }
} 