<?php
namespace event\components\handlers\invite\disapprove;

class Marketingparty2014 extends Base
{
  public function getSubject()
  {
    return 'Закрытая вечеринка для маркетинг директоров';
  }
  
  /**
   * @return string
   */
  public function getBody()
  {
    return \Yii::app()->getController()->renderPartial('event.views.mail.invite.disapprove.marketingparty2014', ['user' => $this->user], true);
  }
}
