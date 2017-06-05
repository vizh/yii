<?php
namespace pay\components\handlers\order\activate;

class Alm14 extends Base
{
    public function getFrom()
    {
        return 'event@runet-id.com';
    }

    public function getFromName()
    {
        return 'ALM Summit';
    }

    protected function getJuridicalViewPath()
    {
        return 'pay.views.mail.order.activate.juridical.alm14';
    }

    protected function getPhysicalViewPath()
    {
        return 'pay.views.mail.order.activate.alm14';
    }
}