<?php
namespace pay\components\handlers\sandbox;

class Base extends \mail\components\Mail
{
    /** @var \user\models\User */
    protected $user;

    /** @var \event\models\Event */
    protected $event;

    public function __construct(\mail\components\Mailer $mailer, \user\models\User $user, \event\models\Event $event)
    {
        parent::__construct($mailer);
        $this->user = $user;
        $this->event = $event;
    }

    public function isHtml()
    {
        return true;
    }

    public function getSubject()
    {
        return 'Экспресс-оплата';
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
    public function getTo()
    {
        return $this->user->Email;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return \Yii::app()->getController()->renderPartial($this->getBodyView(), [
            'user' => $this->user,
            'event' => $this->event
        ], true);
    }

    /**
     * @return string
     */
    protected function getBodyView()
    {
        return 'pay.views.mail.sandbox.base';
    }
}