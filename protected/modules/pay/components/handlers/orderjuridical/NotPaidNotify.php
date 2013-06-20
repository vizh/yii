<?php
namespace pay\components\handlers\orderjuridical;

class NotPaidNotify extends \mail\components\Mail
{
  protected $order;
  public function __construct($order)
  {
    $this->order = $order;
  }
  
  public function isHtml()
  {
    return true;
  }
 
  public function getBody()
  {
    return $this->renderBody('pay.views.mail.orderjuridical.notpaidnotify', array('order' => $this->order));
  }

  public function getFrom()
  {
    return 'users@runet-id.com';
  }
  
  
  public function getSubject()
  {
    return 'Напоминание об оплате счета №'.$this->order->Id;
  }
}
