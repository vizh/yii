<?php
namespace event\components\handlers\register;

class Seminarnetvorking2013 extends Base
{
    public function getSubject()
    {
        return 'Семинар по нетворкингу от Viadeo. 14 октября 17.00';
    }

    public function getBody()
    {
        return $this->renderBody('event.views.mail.register.seminarnetvorking2013', ['user' => $this->user]);
    }

    public function getAttachments()
    {
        return [];
    }
}
