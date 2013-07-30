<?php
namespace mail\components\mail;


use mail\components\Mailer;

class Riw13 extends \mail\components\Mail
{
  protected $user;

  public function __construct(Mailer $mailer, \user\models\User $user)
  {
    parent::__construct($mailer);
    $this->user = $user;
  }

  /**
   * @return string
   */
  public function getFrom()
  {
    return 'users@russianinternetweek.ru';
  }

  public function getFromName()
  {
    return 'RIW 2013';
  }

  public function getSubject()
  {
    return 'Старт приема заявок на конкурс проектов “Аллея инноваций”';
  }

  /**
   * @return string
   */
  public function getTo()
  {
    return $this->user->Email;
  }

  /**
   * @return string
   */
  public function getBody()
  {
    return $this->renderBody('mail.views.partner.riw13-1', ['user' => $this->user]);
  }

}