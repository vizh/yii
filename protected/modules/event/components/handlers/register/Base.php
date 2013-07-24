<?php
namespace event\components\handlers\register;

class Base extends \mail\components\Mail
{
  protected $event;
  protected $user;
  protected $role;
  
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
  
  public function getAttachments()
  {
    $pkPass = new \application\components\utility\PKPassGenerator($this->event, $this->user, $this->role);
//    return array(
//      'ticket.pkpass' => $pkPass->runAndSave()
//    );
    return array();
  }
}
