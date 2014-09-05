<?php
namespace widget\components;

/**
 * Class Action
 * @package widget\components
 *
 * @method Controller getController()
 */
class Action extends \CAction
{
  /**
   * @return \event\models\Event
   */
  public function getEvent()
  {
    return $this->getController()->getEvent();
  }

  /**
   * @return \api\models\Account
   */
  public function getApiAccount()
  {
    return $this->getController()->getApiAccount();
  }
} 