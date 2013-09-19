<?php
namespace event\components\handlers;

class Create extends \mail\components\Mail
{
  protected $form;
  
  public function __construct(\mail\components\Mailer $mailer, \event\models\forms\Create $form)
  {
    parent::__construct($mailer);
    $this->form = $form;
  }

  public function getSubject()
  {
    return 'Получено новое мероприятие';
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
