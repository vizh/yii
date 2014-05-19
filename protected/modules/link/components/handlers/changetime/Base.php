<?php
namespace link\components\handlers\changetime;

/**
 * Class Base
 * @package widget\components\handlers\link\changetime
 * @property \link\models\Link $link
 */
class Base extends \mail\components\MailLayout
{
  protected $link;

  public function __construct(\mail\components\Mailer $mailer, \CEvent $event)
  {
    parent::__construct($mailer);
    $this->link = $event->sender;
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
    return $this->link->User->Email;
  }

  /**
   * @return string
   */
  public function getBody()
  {
    return $this->renderBody('link.views.mail.changetime.base', ['link' => $this->link]);
  }

  protected function getHashSolt()
  {
    return $this->link->Owner->Id.$this->link->Event->Id;
  }

  public function getSubject()
  {
    return $this->link->Owner->getFullName().' просит изменить время Вашей встречи';
  }

  /**
   * @return \user\models\User
   */
  function getUser()
  {
    return $this->link->User;
  }

  /**
   * @return bool
   */
  public function showUnsubscribeLink()
  {
    return false;
  }
}