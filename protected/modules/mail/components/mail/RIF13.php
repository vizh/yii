<?php
namespace mail\components\mail;

class RIF13 extends \mail\components\Mail
{
  public $user = null;
  
  public function getFrom()
  {
    return 'users@rif.ru';
  }
  
  public function getFromName()
  {
    return 'РИФ+КИБ 2013';
  }
  
  public function getSubject()
  {
    return 'Итоги РИФ+КИБ 2013';
  }
  
  public function getBody()
  {
    return \Yii::app()->getController()->renderPartial('mail.views.partner.rif13-1', array('user' => $this->user, 'personalLink' => $this->getPersonalLink()), true);
  }
  
  private function getPersonalLink()
  {
    $secret = 'vyeavbdanfivabfdeypwgruqe';
   	$hash = substr(md5($this->user->RunetId.$secret), 0, 16);
    return 'http://2013.russianinternetforum.ru/my/'.$this->user->RunetId.'/'.$hash .'/?redirect=/vote/';
  }
}
