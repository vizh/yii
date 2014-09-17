<?php
namespace event\components\handlers\invite\disapprove;

use mail\components\MailLayout;

class Base extends MailLayout
{
    protected $event;
    protected $user;

    public function __construct(\mail\components\Mailer $mailer, \CEvent $event)
    {
        parent::__construct($mailer);
        $this->event = $event->sender;
        $this->user  = $event->params['user'];
    }

    public function getTo()
    {
        return $this->user->Email;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return 'users@runet-id.com';
    }

    public function getFromName()
    {
        return '—RUNET—ID—';
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    function getUser()
    {
        return $this->user;
    }

    /**
     * @return bool
     */
    public function showUnsubscribeLink()
    {
        return false;
    }
}
