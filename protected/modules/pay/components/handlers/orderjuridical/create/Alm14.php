<?php
namespace pay\components\handlers\orderjuridical\create;

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

    protected function getViewPath()
    {
        return 'pay.views.mail.orderjuridical.create.alm14';
    }
}