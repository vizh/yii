<?php
namespace event\components\handlers\register;

class Cvs13 extends Base
{
    public function getFrom()
    {
        return 'users@runet-id.com';
    }

    public function getSubject()
    {
        return 'Вы были успешно зарегистрированы на конференцию I МОСКОВСКИЙ КОРПОРАТИВНЫЙ ВЕНЧУРНЫЙ САММИТ!';
    }

    public function getBody()
    {
        return \Yii::app()->getController()->renderPartial('event.views.mail.register.cvs13', ['user' => $this->user, 'participant' => $this->participant], true);
    }
}