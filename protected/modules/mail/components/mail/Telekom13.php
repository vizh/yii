<?php
namespace mail\components\mail;

class Telekom13 extends \mail\components\Mail
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
        return 'Бизнес-форум КоммерсантЪ «Телеком 2013: Точки роста»';
    }

    public function getBody()
    {
        return \Yii::app()->getController()->renderPartial('mail.views.partner.telekom13-1', ['user' => $this->user], true);
    }
}
