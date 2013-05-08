<?php
namespace mail\components\mail;

class Mblt13 extends \mail\components\Mail
{
  public $user  = null;
  
  public function isHtml()
  {
    return true;
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
    return 'Мобильная конференция #MBLT13 уже через неделю!';
  }
  
  public function getBody()
  {
    return \Yii::app()->getController()->renderPartial('mail.views.partner.mblt13-2', array('user' => $this->user), true);
  }
}
