<?php
/**
 * Created by IntelliJ IDEA.
 * User: Alaris
 * Date: 2/17/14
 * Time: 4:44 PM
 */

namespace pay\components\handlers\orderjuridical\create;

class Appsummit14 extends Base
{
    public function getFrom()
    {
        return 'event@runet-id.com';
    }

    public function getFromName()
    {
        return 'AppSummit';
    }

    protected function getViewPath()
    {
        return 'pay.views.mail.orderjuridical.create.appsummit14';
    }
}