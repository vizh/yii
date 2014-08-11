<?php
namespace application\widgets;

class AlertPhoneVerify extends \CWidget
{
  public function run()
  {
    if (!\Yii::app()->getUser()->getIsGuest()) {
      $user = \Yii::app()->getUser()->getCurrentUser();
      if (empty($user->PrimaryPhone) || !$user->PrimaryPhoneVerify) {
        //$this->render('alert-phone-verify', ['user' => $user]);
      }
    }
  }
} 