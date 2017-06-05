<?php
namespace event\components\handlers\register;

class Mipacademy13 extends Base
{
    public function getFrom()
    {
        return 'users@runet-id.com';
    }

    public function getSubject()
    {
        if (\Yii::app()->getLanguage() == 'en') {
            return 'You have been successfully registered for the MIPAcademy Moscow DO';
        }
        return 'Вы были успешно зарегистрированы MIPAcademy Moscow DO';
    }

    public function getBody()
    {
        if (\Yii::app()->getLanguage() == 'en') {
            $view = 'event.views.mail.register.mipacademy13.en';
        } else {
            $view = 'event.views.mail.register.mipacademy13.ru';
        }
        return \Yii::app()->getController()->renderPartial($view, ['user' => $this->user], true);
    }
}
