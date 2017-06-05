<?php
namespace event\components\handlers\register;

class Telekom13 extends Base
{
    public function getFrom()
    {
        return 'users@runet-id.com';
    }

    public function getSubject()
    {
        return 'Вы были успешно зарегистрированы на Бизнес-форум КоммерсантЪ «Телеком 2013: Точки роста»';
    }

    public function getBody()
    {
        return null;
        return \Yii::app()->getController()->renderPartial('event.views.mail.register.telekom13', ['user' => $this->user], true);
    }
}
