<?php
namespace event\components\handlers\register;

use mail\components\MailLayout;
use \mail\models\Layout;

class Base extends MailLayout
{
    /** @var \event\models\Event  */
    protected $event;
    /** @var  \user\models\User */
    protected $user;
    /** @var  \event\models\Role */
    protected $role;
    /** @var  \event\models\Participant */
    protected $participant;

    /**
     *
     * @param \mail\components\Mailer $mailer
     * @param \CEvent $event
     */
    public function __construct(\mail\components\Mailer $mailer, \CEvent $event)
    {
        parent::__construct($mailer);
        $this->event = $event->sender;
        $this->user  = $event->params['user'];
        $this->role  = $event->params['role'];
        $this->participant  = $event->params['participant'];
    }

    /**
     * @var \event\models\MailRegister $registerMail
     */
    private $registerMail = null;
    private function getRegisterMail()
    {
        if ($this->registerMail == null)
        {
            $mails = isset($this->event->MailRegister) ? unserialize(base64_decode($this->event->MailRegister)) : [];
            foreach ($mails as $mail)
            {
                $inExcept = in_array($this->role->Id, $mail->RolesExcept);
                $part1 = in_array($this->role->Id, $mail->Roles) && !$inExcept;
                $part2 = $this->registerMail == null && empty($mail->Roles) && empty($mail->RolesExcept);
                $part3 = empty($mail->Roles) && !empty($mail->RolesExcept) && !$inExcept;
                if ($part1 || $part2 || $part3)
                {
                    $this->registerMail = $mail;
                }
            }
        }
        return $this->registerMail;
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
     * @return null|string
     */
    public function getSubject()
    {
        if ($this->getRegisterMail() !== null)
        {
            return $this->getRegisterMail()->Subject;
        }
        return null;
    }


    /**
     * @return string
     */
    public function getBody()
    {
        if ($this->getRegisterMail() !== null)
        {
            return $this->renderBody(
                $this->getRegisterMail()->getViewName(),
                ['user' => $this->user, 'event' => $this->event, 'participant' => $this->participant, 'role' => $this->role]
            );
        }
        return null;
    }

    public function getAttachments()
    {
        if ($this->getRegisterMail() !== null && !$this->getRegisterMail()->SendPassbook)
        {
            return [];
        }

        $pkPass = new \application\components\utility\PKPassGenerator($this->event, $this->user, $this->role);
        return array(
            'ticket.pkpass' => $pkPass->runAndSave()
        );
    }

    /**
     * @inheritdoc
     */
    function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getLayoutName()
    {
        return isset($this->getRegisterMail()->Layout) ? $this->getRegisterMail()->Layout : Layout::None;
    }

    /**
     * @return bool
     */
    public function showUnsubscribeLink()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function getIsPriority()
    {
        return true;
    }
}
