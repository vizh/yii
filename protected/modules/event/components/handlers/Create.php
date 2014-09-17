<?php
namespace event\components\handlers;

class Create extends \mail\components\Mail
{
  protected $form;
  
  public function __construct(\mail\components\Mailer $mailer, \event\models\forms\Create $form, \event\models\Event $event)
  {
    parent::__construct($mailer);
    $this->form = $form;
    $this->event = $event;
  }

  public function getSubject()
  {
    return 'Новое мероприятие: ' . $this->event->Title;
  }
  
  public function getBody()
  {
    return \Yii::app()->getController()->renderPartial('event.views.mail.create', array('form' => $this->form), true);
  }

  public function getFrom()
  {
    return 'event@'.RUNETID_HOST;
  }

  public function getTo()
  {
    return \Yii::app()->params['EmailEventCalendar'];
  }  
}
