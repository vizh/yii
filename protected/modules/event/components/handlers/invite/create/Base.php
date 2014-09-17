<?php
namespace event\components\handlers\invite\create;

use mail\components\MailLayout;

class Base extends MailLayout
{
    protected $event;
    protected $user;

    public function __construct(\mail\components\Mailer $mailer, \CEvent $event)
    {
        parent::__construct($mailer);
        $this->event = $event->params['event'];
        $this->user  = $event->params['user'];
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return 'users@runet-id.com';
    }

    /**
     * @return string
     */
    public function getFromName()
    {
        return '—RUNET—ID—';
    }

    public function getSubject()
    {
        return 'Новая заявка на участие в '.$this->event->Title;
    }


    /**
     * @return string
     */
    public function getTo()
    {
        return 'vorobieva@raec.ru';
    }

    /**
     * @return bool
     */
    public function isHtml()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return null;
        //return $this->renderBody('event.views.mail.invite.create.base', ['user' => $this->user, 'event' => $this->event]);
    }

    function getUser()
    {
        return $this->user;
    }

    public function showUnsubscribeLink()
    {
        return false;
    }


}