<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 26.02.16
 * Time: 12:29
 */

namespace event\components\handlers\register;


use mail\models\Layout;

class Nspkjun16 extends Base
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

    public function getAttachments()
    {
        return [
            'https://runet-id.com/nspk.nspk.doc'
        ];
    }
}