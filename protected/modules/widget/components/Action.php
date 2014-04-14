<?php
namespace widget\components;

class Action extends \CAction
{
  /**
   * @return \event\models\Event
   */
  public function getEvent()
  {
    return $this->getController()->getEvent();
  }
} 