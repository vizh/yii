<?php
namespace user\components\handlers;


class RecoverCode extends RecoverBase
{
  /**
   * @return string
   */
  public function getBody()
  {
    return $this->renderBody('user.views.mail.recover', [
      'user' => $this->user,
      'type' => 'withCode'
    ], true);
  }
}