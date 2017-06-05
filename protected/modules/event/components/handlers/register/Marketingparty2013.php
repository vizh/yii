<?php
namespace event\components\handlers\register;

class Marketingparty2013 extends Base
{
    public function getSubject()
    {
        return 'Закрытая вечеринка для маркетинг директоров. 18 октября 20.00';
    }

    public function getBody()
    {
        return \Yii::app()->getController()->renderPartial('event.views.mail.register.marketingparty2013', ['user' => $this->user], true);
    }
}
