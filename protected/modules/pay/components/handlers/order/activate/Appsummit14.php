<?php
/**
 * Created by IntelliJ IDEA.
 * User: Alaris
 * Date: 2/17/14
 * Time: 4:42 PM
 */

namespace pay\components\handlers\order\activate;

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

    protected function getJuridicalViewPath()
    {
        return 'pay.views.mail.order.activate.juridical.appsummit14';
    }

    protected function getPhysicalViewPath()
    {
        return 'pay.views.mail.order.activate.appsummit14';
    }
}