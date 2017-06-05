<?php
namespace event\components\handlers\register;

class Mblt2013 extends Base
{
    public function getFrom()
    {
        return 'users@runet-id.com';
    }

    public function getSubject()
    {
        return 'Вы были успешно зарегистрированы #MBLT13 / You have been successfully registered for the #MBLT13';
    }

    public function getBody()
    {
        return \Yii::app()->getController()->renderPartial('event.views.mail.register.mblt2013', ['user' => $this->user], true);
    }
}
