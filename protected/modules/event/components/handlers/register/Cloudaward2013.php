<?php
namespace event\components\handlers\register;

class Cloudaward2013 extends Base
{
  public function getSubject()
  {
    return 'Регистрация на торжественную церемонию вручения ежегодной премии SAAS-решений «Облака 2013»';
  }
  
  public function getBody()
  {
     return \Yii::app()->getController()->renderPartial('event.views.mail.register.cloudaward13', array('user' => $this->user), true);
  }
}
