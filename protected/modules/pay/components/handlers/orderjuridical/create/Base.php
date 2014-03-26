<?php
namespace pay\components\handlers\orderjuridical\create;

class Base extends \mail\components\Mail
{
  /** @var \pay\models\Order */
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
    if ($this->order->Type != \pay\models\OrderType::Receipt)
    {
      return 'Счет на оплату '.$this->event->Title;
    }
    else
    {
      return 'Квитанция на оплату '.$this->event->Title;
    }
  }
  
  public function getBody()
  {
    if (!(\Yii::app()->getController() instanceof \CController))
      return null;

    return \Yii::app()->getController()->renderPartial($this->getViewPath(), array(
      'order' => $this->order,
      'payer' => $this->payer,
      'event' => $this->event,
      'total' => $this->total
    ), true);
  }

  protected function getViewPath()
  {
    return 'pay.views.mail.orderjuridical.create.base';
  }
  
  public function getTo()
  {
    return $this->payer->Email;
  }
}
