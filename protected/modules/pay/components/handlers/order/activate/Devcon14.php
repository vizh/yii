<?php
namespace pay\components\handlers\order\activate;

class Devcon14 extends Base
{
    public function getFrom()
    {
        return 'devcon@runet-id.com';
    }

    public function getFromName()
    {
        return 'DevCon 2014';
    }

    protected function getJuridicalViewPath()
    {
        return 'pay.views.mail.order.activate.juridical.devcon14';
    }

    protected function getPhysicalViewPath()
    {
        return 'pay.views.mail.order.activate.devcon14';
    }
}