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

  /**
   * @return builders\Builder
   */
  public function getDataBuilder()
  {
    return $this->getAccount()->getDataBuilder();
  }

  /**
   * @return \event\models\Event
   */
  public function getEvent()
  {
    return $this->getAccount()->getEvent();
  }

  /**
   * @param mixed $result
   */
  public function setResult($result)
  {
    $this->getController()->setResult($result);
  }

  /**
   * @return int
   */
  protected function getMaxResults()
  {
    return \Yii::app()->params['ApiMaxResults'];
  }
}