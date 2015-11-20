<?php
namespace pay\components\handlers\orderjuridical\create;

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

    protected function getViewPath()
    {
        return 'pay.views.mail.orderjuridical.create.devcon16';
    }

    /**
     * @inheritdoc
     */
    public function showFooter()
    {
        return false;
    }
}