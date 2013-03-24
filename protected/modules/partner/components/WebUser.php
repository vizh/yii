<?php
namespace partner\components;

class WebUser extends \CWebUser
{
  private $account = null;

  /**
   * @return \partner\models\Account
   */
  public function getAccount()
  {
    if ($this->account === null && !\Yii::app()->partner->getIsGuest())
    {
      $this->account = \partner\models\Account::model()->findByPk(\Yii::app()->partner->getId());
    }

    return $this->account;
  }


  protected $event = null;

  /**
   * @throws \application\components\Exception
   * @return \event\models\Event
   */
  public function getEvent()
  {
    if ($this->event === null)
    {
      $this->event = $this->getAccount() !== null ? \event\models\Event::model()->findByPk($this->getAccount()->EventId) : null;
      if ($this->event === null)
      {
        throw new \application\components\Exception('Не найдено мероприятие для данного пользователя партнерского интерфейса');
      }
    }

    return $this->event;
  }

  /**
   * @return null|string
   */
  public function getRole()
  {
    if ($this->getAccount() !== null)
    {
      return $this->getAccount()->Role;
    }
    return null;
  }

  protected $_access = array();

  public function checkAccess($operation,$params=array(),$allowCaching=true)
  {
    if($allowCaching && $params===array() && isset($this->_access[$operation]))
      return $this->_access[$operation];
    else
      return $this->_access[$operation]= \Yii::app()->partnerAuthManager->checkAccess($operation,$this->getId(),$params);
  }
}