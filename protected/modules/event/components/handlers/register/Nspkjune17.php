<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 25.11.16
 * Time: 12:46
 */

namespace event\components\handlers\register;

use mail\models\Layout;

class Nspkjune17 extends Base
{
    public function getFrom()
    {
        return 'orgcenter@nspk.ru';
    }

    public function getFromName()
    {
        return 'НСПК';
    }

    public function showFooter()
    {
        return false;
    }

    public function getLayoutName()
    {
        return Layout::None;
    }

}