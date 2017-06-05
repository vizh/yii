<?php
namespace mail\components\mail;

class Rasia2013 extends \mail\components\Mail
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
        return 'rASiA.com – что ожидает мир завтра?';
    }

    public function getBody()
    {
        return \Yii::app()->getController()->renderPartial('mail.views.partner.rasia13-1', ['user' => $this->user], true);
    }
}
