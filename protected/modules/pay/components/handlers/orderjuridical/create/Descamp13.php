<?php
namespace pay\components\handlers\orderjuridical\create;

class Descamp13 extends Base
{
    public function getFrom()
    {
        return 'event@runet-id.com';
    }

    public function getFromName()
    {
        return 'Design Camp';
    }

    protected function getViewPath()
    {
        return 'pay.views.mail.orderjuridical.create.descamp13';
    }
}