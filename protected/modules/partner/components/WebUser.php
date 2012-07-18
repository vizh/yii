<?php
namespace partner\components;

class WebUser extends \CWebUser 
{
  private $account = null;
  
  public function Account()
  {
    if ($this->account === null && !\Yii::app()->partner->getIsGuest())
    {
      $this->account = \partner\models\Account::model()->findByPk(\Yii::app()->partner->getId());
    }

    return $this->account;
  }
}