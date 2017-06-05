<?php
namespace event\components\handlers\register;

class Rad13 extends Base
{
    public function getSubject()
    {
        return 'Вы успешно зарегистрированы на конференцию  Russian Affiliate Days-2013';
    }

    public function getBody()
    {
        if ($this->role->Id == 24) {
            return null;
        }

        return $this->renderBody('event.views.mail.register.rad13', [
            'user' => $this->user,
            'role' => $this->role,
        ]);
    }

    public function getAttachments()
    {
        return parent::getAttachments();
    }
}
