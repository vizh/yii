<?php
namespace pay\components\handlers\orderjuridical\create;

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

    public function isHtml()
    {
        return true;
    }

    protected function getViewPath()
    {
        return 'pay.views.mail.orderjuridical.create.devcon14';
    }
}