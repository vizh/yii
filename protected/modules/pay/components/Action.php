<?php
namespace pay\components;

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
   * @return \event\models\Event
   */
  public function getEvent()
  {
    return $this->getController()->getEvent();
  }

  /**
   * @return \user\models\User
   */
  public function getUser()
  {
    return $this->getController()->getUser();
  }
}
