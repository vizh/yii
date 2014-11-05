<?php
namespace event\components\handlers\register;

class Vilikesnow14 extends Base
{
    public function getFrom()
    {
        return 'info@vilikessnow.ru';
    }

    public function getFromName()
    {
        return 'Vi LIKES snow 2014';
    }

    public function showFooter()
    {
        return false;
    }

    public function showUnsubscribeLink()
    {
        return false;
    }

    public function getAttachments()
    {
        return [];
    }
}

