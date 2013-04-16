<?php
namespace event\widgets;

class FastRegistration extends \event\components\Widget
{
  public function getAttributeNames()
  {
    return array(
      'DefaultRoleId'
    );
  }
  
  public function process()
  {
    $request = \Yii::app()->getRequest();
    if ($request->getIsPostRequest() && !\Yii::app()->user->isGuest)
    {
      $role = \event\models\Role::model()->findByPk($this->DefaultRoleId);
      $this->event->registerUser(\Yii::app()->user->getCurrentUser(), $role);
      \Yii::app()->getController()->refresh();
    }
  }
  
  public function run()
  {
    $isParticipant = false;
    if (!\Yii::app()->user->isGuest)
    {
      $isParticipant = \event\models\Participant::model()->byUserId(\Yii::app()->user->getId())->byEventId($this->event->Id)->exists();
    }
    $this->render('registration-fast', array('isParticipant' => $isParticipant));
  }
  
  public function getPosition()
  {
    return \event\components\WidgetPosition::Content;
  }
  
  public function getTitle()
  {
    return \Yii::t('app', 'Быстрая регистрация на мероприятии');
  }
}
