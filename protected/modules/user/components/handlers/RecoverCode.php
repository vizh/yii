<?php
namespace user\components\handlers;


class RecoverCode extends RecoverBase
{

  /**
   * @return string
   */
  public function getBody()
  {
    return \Yii::app()->getController()->renderPartial('user.views.mail.recover', array('user' => $this->user, 'type' => 'withCode'), true);
  }
}