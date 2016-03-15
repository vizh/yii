<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 15.04.15
 * Time: 16:02
 */

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
        return 'EXPOCENTRE, ZAO';
    }


    public function showFooter()
    {
        return false;
    }

    /*public function getBody()
    {
        if($this->participant->RoleId == 38) {
            return null;
        }
        parent::getBody();
    }*/

    public function getLayoutName()
    {
        return Layout::None;
    }
}
