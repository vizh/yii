<?php
namespace pay\components\handlers\order\activate;

use mail\models\Layout;

class Devcon16 extends Base
{
    /**
     * @return string
     */
    public function getLayoutName()
    {
        return Layout::DevCon16;
    }

    /**
     * @inheritdoc
     */
    public function getFrom()
    {
        return 'devcon@runet-id.com';
    }

    /**
     * @inheritdoc
     */
    public function getFromName()
    {
        return 'DevCon 2016';
    }

    /**
     * @inheritdoc
     */
    protected function getJuridicalViewPath()
    {
        return $this->getPhysicalViewPath();
    }

    /**
     * @inheritdoc
     */
    protected function getPhysicalViewPath()
    {
        return 'pay.views.mail.order.activate.devcon16';
    }

    /**
     * @inheritdoc
     */
    public function showFooter()
    {
        return false;
    }

}