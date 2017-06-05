<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 15.04.15
 * Time: 16:02
 */

namespace event\components\handlers\register;

use mail\models\Layout;

class odaeda16 extends Base
{

    protected function getRepeat()
    {
        return false;
    }

    public function getAttachments()
    {
        return [];
    }

    public function getLayoutName()
    {
        return Layout::OneColumn;
    }

    public function getFromName()
    {
        return 'Платежная система «Мир»';
    }

    public function showFooter()
    {
        return false;
    }

    public function showUnsubscribeLink()
    {
        return false;
    }

    public function getFrom()
    {
        return 'no-reply@mironline.ru';
    }

}
