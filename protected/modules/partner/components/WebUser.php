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
}