<?php
namespace pay\components\handlers\order\activate;

class Base extends \mail\components\Mail
{
  /** @var \pay\models\Order */
  protected $order;
  /** @var  \user\models\User */
  protected $payer;
  /** @var  \event\models\Event */
  protected $event;
  /** @var  int */
  protected $total;
  public function __construct(\mail\components\Mailer $mailer, \CEvent $event)
  {
    parent::__construct($mailer);
    $this->order = $event->sender;
    $this->payer = $event->sender->Payer;
    $this->event = $event->sender->Event;
    $this->total = $event->params['total'];
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
  
  public function getSubject()
  {
    if ($this->order->Type == \pay\models\OrderType::Receipt)
    {
      return 'Успешная оплата квитанции на '.$this->event->Title;
    }
    elseif ($this->order->Type == \pay\models\OrderType::Juridical)
    {
      return 'Успешная оплата счета на '.$this->event->Title;
    }

    return 'Успешная оплата на '.$this->event->Title;
  }
  
  public function getBody()
  {
    if (!(\Yii::app()->getController() instanceof \CController))
      return null;

    $isBankPayment = \pay\models\OrderType::getIsBank($this->order->Type);
    $view = $isBankPayment ? $this->getJuridicalViewPath() : $this->getPhysicalViewPath();
    $orderItems = [];
    foreach ($this->order->ItemLinks as $link)
    {
      if ($link->OrderItem->Paid)
      {
        $orderItems[] = $link->OrderItem;
      }
    }
    
    if (empty($orderItems))
      return null;
    
    return \Yii::app()->getController()->renderPartial($view, [
      'order' => $this->order,
      'payer' => $this->payer,
      'event' => $this->event,
      'total' => $this->total,
      'items' => $orderItems
    ], true);
  }

  protected function getJuridicalViewPath()
  {
    return 'pay.views.mail.order.activate.juridical.base';
  }

  protected function getPhysicalViewPath()
  {
    return 'pay.views.mail.order.activate.base';
  }
  
  protected function getHashSolt()
  {
    return $this->order->Id;
  }
  
  protected function getRepeat()
  {
    return false;
  }
  
  public function getTo()
  {
    return $this->payer->Email;
  }
}
