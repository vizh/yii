<?php
namespace event\components\handlers\register;

class Kursmarketing extends Base
{
    public function getFrom()
    {
        return 'users@runet-id.com';
    }

    public function getSubject()
    {
        return 'Вы были успешно зарегистрированы на БАЗОВЫЙ КУРС ПО ИНТЕРНЕТ-МАРКЕТИНГУ!';
    }

    public function getBody()
    {
        return \Yii::app()->getController()->renderPartial('event.views.mail.register.kursmarketing', ['user' => $this->user], true);
    }
}
