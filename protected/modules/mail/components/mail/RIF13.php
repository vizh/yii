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
    return 'Доступ к материалам Форума: видео и доклады';
  }
  
  public function getBody()
  {
    return \Yii::app()->getController()->renderPartial('mail.views.partner.rif13-2', array('user' => $this->user, 'personalLink' => $this->getPersonalLink()), true);
  }
  
  private function getPersonalLink()
  {
    $secret = 'vyeavbdanfivabfdeypwgruqe';
   	$hash = substr(md5($this->user->RunetId.$secret), 0, 16);
    return 'http://2013.russianinternetforum.ru/my/'.$this->user->RunetId.'/'.$hash .'/';
  }
}
