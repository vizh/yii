<?php
namespace mail\components\mail;

class RGIF13 extends \mail\components\Mail
{
    public $user = null;

    public function isHtml()
    {
        return true;
    }

    public function getFrom()
    {
        return 'user@runet-id.com';
    }

    public function getFromName()
    {
        return 'RUNET-ID календарь';
    }

    public function getSubject()
    {
        return 'Приглашаем к участию в Четвертом российском форуме по управлению интернетом (RIGF-2013)!';
    }

    public function getBody()
    {
        return \Yii::app()->getController()->renderPartial('mail.views.partner.rgif13-1', ['user' => $this->user], true);
    }
}
