<?php
namespace event\components\handlers\register;

use mail\models\Layout;

class Rii16 extends Base
{
    public function getFrom()
    {
        return 'conference@ts-group.msk.ru';
    }

    public function getFromName()
    {
        return 'ПАО «Ростелеком»';
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
