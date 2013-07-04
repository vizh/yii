<?php
namespace event\widgets;
class InviteRequest extends \event\components\Widget
{
  protected $form;
  
  public function init()
  {
    $this->form = new \event\models\forms\InviteRequest();
  }
  
  public function process()
  {
    $request = \Yii::app()->getRequest();
    $this->form->attributes = $request->getParam(get_class($this->form));
    if ($request->getIsPostRequest() && $this->form->validate())
    {
      $inviteRequest = new \event\models\InviteRequest();
      $inviteRequest->Phone = $this->form->Phone;
      $inviteRequest->Company = $this->form->Company;
      $inviteRequest->Position = $this->form->Position;
      $inviteRequest->Info = $this->form->Info;
      $inviteRequest->UserId = \Yii::app()->getUser()->getId();
      $inviteRequest->EventId = $this->event->Id;
      $inviteRequest->save();
      \Yii::app()->getController()->redirect($this->event->getUrl());
    }
  }
  
  public function run()
  {
    $existsRequest = false;
    if (!\Yii::app()->getUser()->getIsGuest())
    {
      $existsRequest = \event\models\InviteRequest::model()
        ->byUserId(\Yii::app()->getUser()->getId())->byEventId($this->event->Id)->exists();
    }
    $this->render('inviterequest', ['form' => $this->form, 'existsRequest' => $existsRequest]);
  }
  
  public function getPosition()
  {
    return \event\components\WidgetPosition::Content;
  }
  
  public function getTitle()
  {
    return \Yii::t('app','Запрос на участие');
  }
}
