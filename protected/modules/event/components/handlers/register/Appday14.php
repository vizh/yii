<?php
namespace event\components\handlers\register;

class Appday14 extends Base
{
    public function getFromName()
    {
        return 'Конференция Russian App Day';
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

