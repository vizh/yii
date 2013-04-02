<?php
namespace ruvents\components;

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
   * @return DataBuilder
   */
  public function getDataBuilder()
  {
    return $this->getController()->getDataBuilder();
  }

  /**
   * @return \ruvents\models\DetailLog
   */
  public function getDetailLog()
  {
    return $this->getController()->getDetailLog();
  }

  /**
   * @return \ruvents\models\Operator
   */
  public function getOperator()
  {
    return $this->getController()->getOperator();
  }

  /**
   * @return \event\models\Event
   */
  public function getEvent()
  {
    return $this->getController()->getEvent();
  }
}
