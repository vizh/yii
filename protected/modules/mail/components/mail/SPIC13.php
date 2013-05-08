<?php
namespace mail\components\mail;

class SPIC13 extends \mail\components\Mail 
{
  public $user = null;
  
  public function getFrom()
  {
    return 'users@sp-ic.ru';
  }
  
  public function isHtml()
  {
    return true;
  }
  
  public function getFromName()
  {
    return 'СПИК-2013';
  }
  
  public function getSubject()
  {
    // Для рекламной
    return 'Приглашение на СПИК 2013!';
    
    // Для электронного приглашения
    //return 'Электронное приглашение на СПИК 2013!';
  }
  
  public function getBody()
  {
    //Для рекламной
    return \Yii::app()->getController()->renderPartial('mail.views.partner.spic13-3', array('user' => $this->user, 'personalLink' => $this->getPersonalLink()), true);
    
    // Для электронного приглашения
    //$role = $this->user->Participants[0]->Role;
    //return \Yii::app()->getController()->renderPartial('mail.views.partner.spic13-2', array('user' => $this->user, 'role' => $role, 'qrcodeLink' => $this->getQrCodeLink()), true);
  }
  
  private function getQrCodeLink()
  {
    $qrCode = new \ext\qrcode\QRCode('~RUNETID#'.$this->user->RunetId.'$');
    $path  = \Yii::getPathOfAlias('webroot.images.mail.spic13.ticket.qrcode').'/'.$this->user->RunetId.'.png';
    $qrCode->create($path);
    return 'http://runet-id.com/images/mail/spic13/ticket/qrcode/'.$this->user->RunetId.'.png';
  }

  private function getPersonalLink()
  {
    $hash = substr(md5($this->user->RunetId.'xggMpIQINvHqR0QlZgZa'), 0, 16);;
    return 'http://2013.sp-ic.ru/my/'.$this->user->RunetId.'/'.$hash.'/';
  }
}

?>
