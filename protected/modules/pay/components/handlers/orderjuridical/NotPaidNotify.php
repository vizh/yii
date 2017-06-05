<?php
namespace pay\components\handlers\orderjuridical;

class NotPaidNotify extends \mail\components\Mail
{
    protected $order;

    public function __construct($mailer, $order)
    {
        parent::__construct($mailer);
        $this->order = $order;
    }

    public function isHtml()
    {
        return true;
    }

    public function getBody()
    {
        return $this->renderBody('pay.views.mail.orderjuridical.notpaidnotify', ['order' => $this->order]);
    }

    public function getFrom()
    {
        return 'users@runet-id.com';
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
        return $this->order->Payer->Email;
    }

    public function getSubject()
    {
        return 'Напоминание об оплате счета №'.$this->order->Id;
    }
}
