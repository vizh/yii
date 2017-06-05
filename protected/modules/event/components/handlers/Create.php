<?php
namespace event\components\handlers;

use event\models\Event;
use event\models\forms\Create as CreateForm;
use mail\components\Mail;
use mail\components\Mailer;

class Create extends Mail
{
    /** @var Create */
    protected $form;

    /** @var string */
    protected $to = null;

    public function __construct(Mailer $mailer, CreateForm $form, Event $event)
    {
        parent::__construct($mailer);
        $this->form = $form;
        $this->event = $event;
    }

    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return 'Новое мероприятие: '.$this->event->Title;
    }

    /**
     * @inheritdoc
     */
    public function getBody()
    {
        return \Yii::app()->getController()->renderPartial('event.views.mail.create', ['form' => $this->form], true);
    }

    /**
     * @inheritdoc
     */
    public function getFrom()
    {
        return 'event@'.RUNETID_HOST;
    }

    /**
     * @inheritdoc
     */
    public function getTo()
    {
        if ($this->to === null) {
            return \Yii::app()->params['EmailEventCalendar'];
        }
        return $this->to;
    }

    /**
     * @inheritdoc
     */
    public function setTo($to)
    {
        $this->to = $to;
    }
}
