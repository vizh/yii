<?php
namespace event\widgets;

/**
 * Class FastRegistration
 * @package event\widgets
 *
 * @property int $DefaultRoleId
 */
class FastRegistration extends \event\components\Widget
{ 
  public function getAttributeNames()
  {
    return ['DefaultRoleId'];
  }
  
  public function process()
  {
    $request = \Yii::app()->getRequest();
    if (!\Yii::app()->user->isGuest && ($request->getIsPostRequest() || \Yii::app()->user->getIsRecentlyLogin()))
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
    
    $this->render('registration-fast', [
      'isParticipant' => $isParticipant,
      'event' => $this->event,
      'role' => \event\models\Role::model()->findByPk($this->DefaultRoleId)
    ]);
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
