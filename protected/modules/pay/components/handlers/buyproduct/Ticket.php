<?php
namespace pay\components\handlers\buyproduct;

class Ticket extends Base
{
    /**
     * @var \pay\models\Coupon[] $coupons
     */
    protected $coupons;

    public function __construct(\mail\components\Mailer $mailer, \CEvent $event)
    {
        parent::__construct($mailer, $event);
        $this->coupons = $event->params['coupons'];
    }


    public function getSubject()
    {
        return 'Билеты "' . $this->product->Title . '"';
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->renderBody('pay.views.mail.buyproduct.ticket', ['product' => $this->product, 'payer' => $this->payer, 'coupons' => $this->coupons]);
    }

    /**
     * @return bool
     */
    public function getIsPriority()
    {
        return true;
    }
}