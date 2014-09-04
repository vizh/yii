<?php
namespace event\widgets;

use event\models\forms\InviteActivation;
use event\models\InviteRequest;
use event\models\UserData;

/**
 * Class Invite
 * @package event\widgets
 *
 * @property string $WidgetInviteTitle
 * @property string $WidgetInviteDescription
 * @property integer $WidgetInviteHideCodeInput
 */
class Invite extends \event\components\Widget
{
  public function getAttributeNames()
  {
    return ['WidgetInviteTitle', 'WidgetInviteDescription', 'WidgetInviteHideCodeInput'];
  }

    const SVMR14ID = 1361;

    /**
     * @var InviteActivation
     */
    protected $formRequest;

    /**
     * @var InviteRequest
     */
    protected $formActivation;

    /**
     * @var UserData
     */
    protected $userData = null;
  
  public function init()
  {
    $this->formActivation = new \event\models\forms\InviteActivation($this->event);
    $this->formRequest = new \event\models\forms\InviteRequest();
      $this->userData = new UserData();
      $this->userData->EventId = $this->event->Id;
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
        $this->formRequest->FullName = $this->formActivation->FullName = \Yii::app()->user->getCurrentUser()->getFullName();
        $this->formRequest->RunetId = $this->formActivation->RunetId = \Yii::app()->user->getCurrentUser()->RunetId;
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

    protected $socialProfile = '';
    protected $other = '';
  
  private function processRequest()
  {
    $request = \Yii::app()->getRequest();
    $this->formRequest->attributes = $request->getParam(get_class($this->formRequest));

      $this->formRequest->validate();



      if ($this->event->Id == Invite::SVMR14ID) {
          $this->socialProfile = trim($request->getParam('SocialProfile', ''));
          if (empty($this->socialProfile)) {
              $this->formRequest->addError('SocialProfile', 'Необходимо заполнить поле "Ссылка на профайл"');
          }
          $this->other = trim($request->getParam('Other', ''));
          if (empty($this->other)) {
              $this->formRequest->addError('Other', 'Необходимо заполнить поле "Почему вы хотите принять участие в конференции"');
          }
      }

    if (!$this->formRequest->hasErrors())
    {
      $user = \user\models\User::model()->byRunetId($this->formRequest->RunetId)->find();
        if (InviteRequest::model()->byEventId($this->event->Id)->byOwnerUserId($user->Id)->exists()) {
            $this->formRequest->addError('FullName', sprintf('%s уже подал заявку на участие.', $user->getFullName()));
            return;
        }
      $inviteRequest = new \event\models\InviteRequest();
      $inviteRequest->OwnerUserId  = $user->Id;
      $inviteRequest->SenderUserId = \Yii::app()->user->getCurrentUser()->Id;
      $inviteRequest->EventId = $this->event->Id;
      $inviteRequest->save();

        $userData = new UserData();
        $userData->EventId = $this->event->Id;
        $userData->UserId = $user->Id;
        $userData->CreatorId = \Yii::app()->user->getCurrentUser()->Id;
        $userData->Attributes = json_encode(['SocialProfile' => $this->socialProfile, 'Other' => $this->other], JSON_UNESCAPED_UNICODE);
        $userData->save();
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
    $this->render('invite/index');
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