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
}
