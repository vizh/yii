<?php
namespace event\components\handlers\register;

use mail\models\Layout;

class Svyaz16 extends Base
{
    public function getFrom()
    {
        return 'reply@tickets.expocentr.ru';
    }

    public function getFromName()
    {
        return 'EXPOCENTRE, AO';
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
