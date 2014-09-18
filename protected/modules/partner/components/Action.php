<?php
namespace partner\components;

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
    return \Yii::app()->partner->getEvent();
  }


}
