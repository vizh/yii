<?php
namespace pay\components\handlers\orderjuridical\notify\notpaid;

class Appday14 extends Base
{
    public function getFrom()
    {
        return 'event@runet-id.com';
    }

    public function getBody()
    {
        return $this->renderBody('pay.views.mail.orderjuridical.notify.notpaid.appday14', ['order' => $this->order]);
    }
}