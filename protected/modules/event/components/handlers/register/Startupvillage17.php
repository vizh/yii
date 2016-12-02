<?php
namespace event\components\handlers\register;

class Startupvillage17 extends Base
{
    public function getFrom()
    {
        return 'support@startupvillage.ru';
    }

    public function getFromName()
    {
        return 'Startup Village 2017';
    }

    public function getSubject()
    {
        return \Yii::app()->getLanguage() === 'ru'
            ? 'Спасибо за регистрацию на Startup Village 2017!'
            : 'Thank you for registration on Startup Village 2017!';
    }

}
