<?php
namespace event\components\handlers\register;

class Mblt2013 extends Base
{
  public function getFrom()
  {
    return 'users@runet-id.com';
  }
  
  public function getSubject()
  {
    return 'Вы были успешно зарегистрированы MIPAcademy Moscow DO / You have been successfully registered for the MIPAcademy Moscow DO';
  }
  
  public function getBody()
  {
    return \Yii::app()->getController()->renderPartial('event.views.mail.register.mblt2013', array('user' => $this->user), true);
  }
}
