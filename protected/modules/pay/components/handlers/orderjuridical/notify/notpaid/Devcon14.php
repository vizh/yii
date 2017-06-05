<?php
namespace pay\components\handlers\orderjuridical\notify\notpaid;

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

    public function getBody()
    {
        return $this->renderBody('pay.views.mail.orderjuridical.notify.notpaid.devcon14', ['order' => $this->order]);
    }
}