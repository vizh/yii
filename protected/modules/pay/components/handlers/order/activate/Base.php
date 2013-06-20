<?php
namespace pay\components\handlers\order\activate;

class Base extends \mail\components\Mail
{
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
  
  public function getSubject()
  {
    if ($this->order->Juridical)
    {
      return 'Успешная оплата счета на '.$this->event->Title;
    }
    return 'Успешная оплата на '.$this->event->Title;
  }
  
  public function getBody()
  {
    $view = $this->order->Juridical ? 'pay.views.mail.order.activate.juridical.base' : 'pay.views.mail.order.activate.base';
    $orderItems = array();
    foreach ($this->order->ItemLinks as $link)
    {
      if ($link->OrderItem->Paid)
      {
        $orderItems[] = $link->OrderItem;
      }
    }
    
    if (empty($orderItems))
      return null;
    
    return \Yii::app()->getController()->renderPartial($view, array(
      'order' => $this->order,
      'payer' => $this->payer,
      'event' => $this->event,
      'total' => $this->total,
      'items' => $orderItems
    ), true);
  }
  
  protected $order;
  protected $payer;
  protected $event;
  protected $total;
  public function onActivate($eventHandler)
  {
    $this->order = $eventHandler->sender;
    $this->payer = $eventHandler->sender->Payer;
    $this->event = $eventHandler->sender->Event;
    $this->total = $eventHandler->params['total'];
    if ($this->getBody() !== null)
    {
      $mailer = new \mail\components\Mailer();
      $mailer->send($this, $this->payer->Email, $this->order->Id);
    }
  }
}
