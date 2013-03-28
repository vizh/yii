<?php
namespace event\components\handlers\register;

class Base extends \mail\components\Mail
{

  /**
   * @return string
   */
  public function getFrom()
  {
    // TODO: Implement getFrom() method.
  }

  /**
   * @return string
   */
  public function getBody()
  {
    return null;
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
      $mailer->send($this, $this->user->Email);
    }
  }
}
