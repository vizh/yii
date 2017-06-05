<?php
namespace mail\components\mail;

class RITpp13 extends \mail\components\Mail
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
        return 'РИТ++ - успейте зарегистрироваться';
    }

    public function getBody()
    {
        return \Yii::app()->getController()->renderPartial('mail.views.partner.ritpp13-1', ['user' => $this->user], true);
    }
}
