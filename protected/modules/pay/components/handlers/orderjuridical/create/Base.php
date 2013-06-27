<?php
namespace pay\components\handlers\orderjuridical\create;

class Base extends \mail\components\Mail
{
  protected $order;
  protected $payer;
  protected $event;
  protected $total;
  public function __construct(\mail\components\Mailer $mailer, \CEvent $event)
  {
    parent::__construct($mailer);
    $this->order = $event->sender;
    $this->payer = $event->params['payer'];
    $this->event = $event->params['event'];
    $this->total = $event->params['total'];
  }
  
  public function getFrom()
  {
    return 'fin@runet-id.com';
  }
  
  public function getFromName()
  {
    return 'RUNET—ID';
  }
  
  public function getSubject()
  {
    return 'Выставлен счет на оплату '.$this->event->Title;
  }
  
  public function getBody()
  {
    return \Yii::app()->getController()->renderPartial('pay.views.mail.orderjuridical.create.base', array(
      'order' => $this->order,
      'payer' => $this->payer,
      'event' => $this->event,
      'total' => $this->total
    ), true);
  }
  
  public function getTo()
  {
    return $this->payer->Email;
  }
}
