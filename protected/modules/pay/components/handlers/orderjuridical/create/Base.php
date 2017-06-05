<?php
namespace pay\components\handlers\orderjuridical\create;

use event\models\Event;
use mail\components\MailLayout;
use user\models\User;

class Base extends MailLayout
{
    /** @var \pay\models\Order */
    protected $order;

    /** @var User */
    protected $payer;

    /** @var Event */
    protected $event;

    /** @var int */
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
        if ($this->order->Type != \pay\models\OrderType::Receipt) {
            return 'Счет на оплату '.$this->event->Title;
        } else {
            return 'Квитанция на оплату '.$this->event->Title;
        }
    }

    public function getBody()
    {
        if (!(\Yii::app()->getController() instanceof \CController)) {
            return null;
        }

        return $this->renderBody($this->getViewPath(), [
            'order' => $this->order,
            'payer' => $this->payer,
            'event' => $this->event,
            'total' => $this->total
        ]);
    }

    /**
     * @return string
     */
    protected function getViewPath()
    {
        $alias = 'pay.views.mail.orderjuridical.create.'.strtolower($this->event->IdName);
        $path = \Yii::getPathOfAlias($alias).'.php';
        if (file_exists($path)) {
            return $alias;
        }
        return 'pay.views.mail.orderjuridical.create.base';
    }

    public function getTo()
    {
        return $this->payer->Email;
    }

    /**
     * @inheritdoc
     */
    function getUser()
    {
        return $this->payer;
    }

    /**
     * @return bool
     */
    public function showUnsubscribeLink()
    {
        return false;
    }
}
