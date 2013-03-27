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
    // TODO: Implement getBody() method.
  }


  /**
   * @param \CEvent $event
   */
  public function onRegister($event)
  {
    $mailer = new \mail\components\Mailer();
    $mailer->send($this, '');
  }
}
