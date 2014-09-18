<?php
namespace pay\components\handlers\orderjuridical\create;

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

    protected function getViewPath()
    {
        return 'pay.views.mail.orderjuridical.create.appday14';
    }
}