<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 26.02.16
 * Time: 12:29
 */

namespace event\components\handlers\register;


use mail\models\Layout;

class Nspkmarch15 extends Base
{
    public function getFrom()
    {
        return 'no-reply@nspk.ru';
    }
    public function getFromName()
    {
        return 'НСПК';
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