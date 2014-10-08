<?php
namespace pay\components\handlers\order\activate;

class Appday14 extends Base
{
    public function getFrom()
    {
        return 'event@runet-id.com';
    }

    public function getFromName()
    {
        return 'Russian App Day';
    }

    protected function getJuridicalViewPath()
    {
        return 'pay.views.mail.order.activate.juridical.appday14';
    }

    protected function getPhysicalViewPath()
    {
        return 'pay.views.mail.order.activate.appday14';
    }

    public function getSubject()
    {
        if ($this->order->Type == \pay\models\OrderType::Receipt) {
            return 'Успешная оплата квитанции на участие в конференции '.$this->event->Title;
        } elseif ($this->order->Type == \pay\models\OrderType::Juridical) {
            return 'Успешная оплата счета на участие в конференции '.$this->event->Title;
        }

        return 'Успешная оплата участия в конференции '.$this->event->Title;
    }
}