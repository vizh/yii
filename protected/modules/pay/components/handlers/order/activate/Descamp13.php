<?php
/**
 * Created by IntelliJ IDEA.
 * User: Alaris
 * Date: 11/18/13
 * Time: 4:05 PM
 * To change this template use File | Settings | File Templates.
 */

namespace pay\components\handlers\order\activate;

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

    protected function getJuridicalViewPath()
    {
        return 'pay.views.mail.order.activate.juridical.descamp13';
    }

    protected function getPhysicalViewPath()
    {
        return 'pay.views.mail.order.activate.descamp13';
    }
}