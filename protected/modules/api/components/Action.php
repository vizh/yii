<?php
namespace api\components;

class Action extends \CAction
{

  /**
   * @return Controller
   */
  public function getController()
  {
    return parent::getController();
  }

  /**
   * @return \api\models\Account
   */
  public function getAccount()
  {
    return $this->getController()->Account();
  }
}