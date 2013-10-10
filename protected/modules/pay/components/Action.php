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

  protected $account = null;

  /**
   * @return \pay\models\Account
   * @throws Exception
   */
  public function getAccount()
  {
    $this->account = \pay\models\Account::model()->byEventId($this->getEvent()->Id)->find();
    if ($this->account === null)
    {
      throw new \pay\components\Exception('Для работы платежного кабинета необходимо создать платежный аккаунт мероприятия.');
    }
    return $this->account;
  }
}
