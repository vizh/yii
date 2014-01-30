<?php
namespace pay\components\handlers\buyproduct;

abstract class Base extends \mail\components\Mail
{
  /** @var \pay\models\Order */
  protected $product;
  /** @var  \user\models\User */
  protected $payer;

  public function __construct(\mail\components\Mailer $mailer, \CEvent $event)
  {
    parent::__construct($mailer);
    $this->product = $event->sender;
    $this->payer   = $event->params['payer'];
  }
  
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
    return '—RUNET—ID';
  }
  
  public function getTo()
  {
    return $this->payer->Email;
  }
}
