<?php
namespace user\components\handlers;


use mail\components\Mailer;

class RecoverPassword extends RecoverBase
{
  private $password;

  public function __construct(Mailer $mailer, \user\models\User $user, $password)
  {
    parent::__construct($mailer, $user);
    $this->password = $password;
  }


  /**
   * @return string
   */
  public function getBody()
  {
    return \Yii::app()->getController()->renderPartial('user.views.mail.recover', [
      'user' => $this->user,
      'type' => 'withPassword',
      'password' => $this->password
    ], true);
  }
}