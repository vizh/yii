<?php
namespace pay\components\handlers\orderjuridical\notify\notpaid;

use mail\components\MailLayout;

class Base extends MailLayout
{
    protected $order;

    public function __construct($mailer, $order)
    {
        parent::__construct($mailer);
        $this->order = $order;
    }

    public function getBody()
    {
        return $this->renderBody($this->getViewPath(), ['order' => $this->order]);
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

    /**
     * @inheritdoc
     */
    function getUser()
    {
        return $this->order->Payer;
    }

    /**
     * @return bool
     */
    public function showUnsubscribeLink()
    {
        return false;
    }

    /**
     * @return string
     */
    protected function getViewPath()
    {
        return 'pay.views.mail.orderjuridical.notify.notpaid.base';
    }
}
