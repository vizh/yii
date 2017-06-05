<?php
namespace mail\components\mail;

class RIFvrn13 extends \mail\components\Mail
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
        return '22 апреля - последний день регистрации на РИФ-Воронеж 2013';
    }

    public function getBody()
    {
        return \Yii::app()->getController()->renderPartial('mail.views.partner.rifvrn13-1', ['user' => $this->user], true);
    }
}
