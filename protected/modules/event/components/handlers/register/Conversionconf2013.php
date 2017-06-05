<?php
namespace event\components\handlers\register;

class Conversionconf2013 extends Base
{
    public function getFrom()
    {
        return 'users@runet-id.com';
    }

    public function getSubject()
    {
        return 'Вы были успешно зарегистрированы на ConversionConf 2013!';
    }

    public function getBody()
    {
        return \Yii::app()->getController()->renderPartial('event.views.mail.register.conversionconf13', ['user' => $this->user], true);
    }
}