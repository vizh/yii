<?php
namespace event\components\handlers\register;

class Demo2013 extends Base
{
    public function getFrom()
    {
        return 'users@runet-id.com';
    }

    public function getSubject()
    {
        if (\Yii::app()->getLanguage() == 'en') {
            return 'You have been successfully registered for the DEMO-EUROPE conference';
        }
        return 'Вы были успешно зарегистрированы на конференцию DEMO-EUROPE';
    }

    public function getBody()
    {
        if (\Yii::app()->getLanguage() == 'en') {
            $view = 'event.views.mail.register.demo13.en';
        } else {
            $view = 'event.views.mail.register.demo13.ru';
        }
        return \Yii::app()->getController()->renderPartial($view, ['user' => $this->user], true);
    }
}
