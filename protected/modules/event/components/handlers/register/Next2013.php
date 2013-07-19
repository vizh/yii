<?php 
namespace event\components\handlers\register;

class Next2013 extends Base
{
  public function getSubject()
  {
    return 'Ваша регистрация на конференцию Generaetion NEXT 2013 одобрена оргкомитетом. ';
  }
  
  public function getBody()
  {
    return \Yii::app()->getController()->renderPartial('event.views.mail.register.next13', array('user' => $this->user), true);
  }
}
