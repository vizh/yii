<?php
namespace pay\components\handlers\orderjuridical\create;

class Base extends \mail\components\Mail
{
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
  
  protected $order;
  protected $payer;
  protected $event;
  protected $total;
  public function onCreateOrderJuridical($eventHandler)
  {
    $this->order = $eventHandler->sender;
    $this->payer = $eventHandler->params['payer'];
    $this->event = $eventHandler->params['event'];
    $this->total = $eventHandler->params['total'];
    if ($this->getBody() !== null)
    {
      $mailer = new \mail\components\Mailer();
      $mailer->send($this, $this->payer->Email);
    }
  }
}
