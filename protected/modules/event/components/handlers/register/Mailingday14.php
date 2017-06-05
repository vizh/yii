<?php
namespace event\components\handlers\register;

class Mailingday14 extends Base
{
    public function getBody()
    {
        if ($this->role->Id == 26) {
            return $this->renderBody('event.views.mail.register.mailingday14-video', ['user' => $this->user, 'event' => $this->event, 'participant' => $this->participant]);
        }
        return parent::getBody();
    }

    public function getAttachments()
    {
        if ($this->role->Id == 26) {
            return [];
        }
        return parent::getAttachments();
    }

} 