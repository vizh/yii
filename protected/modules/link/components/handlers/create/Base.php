<?php
namespace link\components\handlers\create;

/**
 * Class Base
 * @package widget\components\handlers\link\create
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
    return $this->link->Owner->Email;
  }

  /**
   * @return string
   */
  public function getBody()
  {
    return $this->renderBody('link.views.mail.create.base', ['link' => $this->link]);
  }

  protected function getHashSolt()
  {
    return $this->link->User->Id.$this->link->Event->Id;
  }

  public function getSubject()
  {
    return $this->link->User->getFullName().' заинтересован в знакомстве с Вами и предлагает встретиться';
  }

  /**
   * @return \user\models\User
   */
  function getUser()
  {
    return $this->link->Owner;
  }

  /**
   * @return bool
   */
  public function showUnsubscribeLink()
  {
    return false;
  }
}