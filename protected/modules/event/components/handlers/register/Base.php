<?php
namespace event\components\handlers\register;

class Base extends \mail\components\Mail
{

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
    return array(
      'ticket.pkpass' => $pkPass->runAndSave()
    );
  }

  protected $event;
  protected $user;
  protected $role;
  /**
   * @param \CEvent $event
   */
  public function onRegister($event)
  {
    $this->event = $event->sender;
    $this->user  = $event->params['user'];
    $this->role  = $event->params['role'];
    if ($this->getBody() !== null)
    {
      $mailer = new \mail\components\Mailer();
      $mailer->send($this, $this->user->Email, null, true);
    }
  }
}
