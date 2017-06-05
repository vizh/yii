<?php
namespace event\components\handlers\register;

class Userexp2013 extends Base
{
    public function getSubject()
    {
        return 'Вы успешно зарегистрированы на конференцию User eXperience 2013';
    }

    public function getBody()
    {
        return $this->renderBody('event.views.mail.register.userexp2013', [
            'user' => $this->user,
            'role' => $this->role,
            'event' => $this->event,
            'participant' => $this->participant
        ]);
    }

    public function getAttachments()
    {
        if ($this->role->Id == 24) {
            return [];
        }
        return parent::getAttachments();
    }
}
