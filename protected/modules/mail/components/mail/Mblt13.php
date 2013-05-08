<?php
namespace mail\components\mail;

class Mblt13 extends \mail\components\Mail
{
  public $user  = null;
  
  public function isHtml()
  {
    return false;
  }
  
  public function getFrom()
  {
    return 'users@runet-id.com';
  }
  
  public function getFromName()
  {
    return '—RUNET—ID—';
  }
  
  public function getSubject()
  {
    return '#MBLT13 - неоплаченный заказ!';
  }
  
  public function getBody()
  {
    return \Yii::app()->getController()->renderPartial('mail.views.partner.mblt13-3', array('user' => $this->user), true);
  }
}
