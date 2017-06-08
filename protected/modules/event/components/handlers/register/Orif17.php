<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 07.06.17
 * Time: 18:06
 */

namespace event\components\handlers\register;

use mail\models\Layout;

class Orif17 extends Base
{
    public function getFromName()
    {
        return 'Oriflame_ТВОЙ СТАРТ';
    }

    public function showFooter()
    {
        return false;
    }
//
//    public function showUnsubscribeLink()
//    {
//        return false;
//    }
//
//    protected function getRepeat()
//    {
//        return false;
//    }
//
//    public function getAttachments()
//    {
//        return [];
//    }

    public function getLayoutName()
    {
        return Layout::None;
    }
}