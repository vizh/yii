<?php
namespace user\components\handlers;

use mail\components\Mailer;

abstract class RecoverBase extends \mail\components\Mail
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
    return 'users@runet-id.com';
  }

  public function getFromName()
  {
    return 'RUNET-ID';
  }

  public function getSubject()
  {
    return \Yii::t('app', 'Восстановление пароля');
  }

  public function isHtml()
  {
    return true;
  }


  /**
   * @return string
   */
  public function getTo()
  {
    return $this->user->Email;
  }

}