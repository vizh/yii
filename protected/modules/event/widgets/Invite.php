<?php
namespace event\widgets;
class Invite extends \event\components\Widget
{
  protected $formRequest;
  protected $formActivation;
  
  public function init()
  {
    $this->formActivation = new \event\models\forms\InviteActivation($this->event);
    $this->formRequest = new \event\models\forms\InviteRequest();
    parent::init();
  }
  
  public function process()
  {
    $request = \Yii::app()->getRequest();
    if (!\Yii::app()->getUser()->getIsGuest())
    {
      if ($request->getIsPostRequest() && ($form = $request->getParam('Form')) !== null)
      {
        switch ($form)
        {
          case get_class($this->formActivation):
            $this->processActivation();
            break;

          case get_class($this->formRequest):
            $this->processRequest();
            break;
        }
      }
      else
      {
        $this->formRequest->FullName = $this->formActivation->FullName = \Yii::app()->getUser()->getCurrentUser()->getFullName();
        $this->formRequest->RunetId = $this->formActivation->RunetId = \Yii::app()->getUser()->getCurrentUser()->RunetId;
      }
    }
  }
  
  private function processActivation()
  {
    $request = \Yii::app()->getRequest();
    $this->formActivation->attributes = $request->getParam(get_class($this->formActivation)); 
    if ($this->formActivation->validate())
    {
      $invite = \event\models\Invite::model()->byCode($this->formActivation->Code)->find();
      $user = \user\models\User::model()->byRunetId($this->formActivation->RunetId)->find();
      $invite->activate($user);
      \Yii::app()->getUser()->setFlash('widget.invite.success', 
        \Yii::t('app', 'Вы успешно активировали приглашение на <strong>«{event}»</strong> со статусом <strong>«{role}»</strong>.', ['{event}' => $invite->Event->Title, '{role}' => $invite->Role->Title])
      );
      \Yii::app()->getController()->refresh();
    }
  }
  
  private function processRequest()
  {
    $request = \Yii::app()->getRequest();
    $this->formRequest->attributes = $request->getParam(get_class($this->formRequest));
    if ($this->formRequest->validate())
    {
      $user = \user\models\User::model()->byRunetId($this->formRequest->RunetId)->find();
      $inviteRequest = new \event\models\InviteRequest();
      $inviteRequest->OwnerUserId  = $user->Id;
      $inviteRequest->SenderUserId = \Yii::app()->getUser()->getCurrentUser()->Id;
      $inviteRequest->EventId = $this->event->Id;
      $inviteRequest->save();
      \Yii::app()->getUser()->setFlash('widget.invite.success', 
        \Yii::t('app', 'Ваша заявка на участие в <strong>«{event}»</strong> принята к рассмотрению', ['{event}' => $this->event->Title])
      );
      \Yii::app()->getController()->refresh();
    }
  }

  public function getIsHasDefaultResources()
  {
    return true;
  }
  
  public function run()
  {
    $this->render('invite', ['formActivation' => $this->formActivation, 'formRequest' => $this->formRequest]);
  }
  
  public function getPosition()
  {
    return \event\components\WidgetPosition::Content;
  }
  
  public function getTitle()
  {
    return \Yii::t('app','Участие по приглашениям');
  }
}