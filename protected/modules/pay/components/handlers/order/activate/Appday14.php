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
}