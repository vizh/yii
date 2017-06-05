<?php
namespace event\components\handlers\register;

class Seokouch2013 extends Base
{
    public function getFrom()
    {
        return 'users@runet-id.com';
    }

    public function getSubject()
    {
        return 'Вы были успешно зарегистрированы на SEO Коучинг!';
    }

    public function getBody()
    {
        return \Yii::app()->getController()->renderPartial('event.views.mail.register.seokouch2013', ['user' => $this->user], true);
    }
}