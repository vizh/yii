<?php
namespace event\components\handlers\register;

class Base extends \mail\components\Mail
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
    if (isset($this->event->MailRegisterSubject))
    {
      return $this->event->MailRegisterSubject;
    }
    return null;
  }


  /**
   * @return string
   */
  public function getBody()
  {
    if (isset($this->event->MailRegisterBodyRendered))
    {
      $view = 'event.views.mail.register.'.strtolower($this->event->IdName);
      return $this->renderBody($view, ['user' => $this->user, 'event' => $this->event, 'participant' => $this->participant]);
    }
    return null;
  }
  
  public function getAttachments()
  {
    $pkPass = new \application\components\utility\PKPassGenerator($this->event, $this->user, $this->role);
    return array(
      'ticket.pkpass' => $pkPass->runAndSave()
    );
  }
}
