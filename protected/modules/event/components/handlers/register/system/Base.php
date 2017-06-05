<?php
namespace event\components\handlers\register\system;

class Base extends \event\components\handlers\register\Base
{
    public function getTo()
    {
        return null;
    }

    public function getSubject()
    {
        return 'На '.$this->event->Title.' зарегистрировался новый пользователь';
    }

    public function getBody()
    {
        return $this->renderBody('event.views.mail.register.system.base', ['user' => $this->user, 'role' => $this->role, 'event' => $this->event]);
    }

    /**
     * @inheritdoc
     */
    public function getAttachments()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    protected function getRepeat()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected function getHashSolt()
    {
        return $this->user->Id;
    }
}
