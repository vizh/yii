<?php
namespace mail\components\mail;

class PhDays13 extends \mail\components\Mail
{
  public $user = null;
  
  public function isHtml()
  {
    return true;
  }
  
  public function getFrom()
  {
    return 'user@runet-id.com';
  }
  
  public function getFromName()
  {
    return 'RUNET-ID календарь';
  }
  
  public function getSubject()
  {
    return 'Форум Positive Hack Days 2013 - регистрация открыта!';
  }
  
  public function getBody()
  {
    return \Yii::app()->getController()->renderPartial('mail.views.partner.phdays13-1', array('user' => $this->user), true);
  }
}
