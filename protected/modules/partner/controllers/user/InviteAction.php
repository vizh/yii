<?php
namespace partner\controllers\user;

class InviteAction extends \partner\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    if (($action = $request->getParam('Action')) !== null)
    {
      if ($request->getIsAjaxRequest() && $action == 'generate')
        $this->processGenerate();
      elseif ($request->getIsPostRequest()) 
      {
        switch ($action)
        {
          case 'approved':
            $this->processApproved(\event\models\Approved::Yes);
            break;
          case 'disapproved':
            $this->processApproved(\event\models\Approved::No);
            break;
        }
      }
    }

    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."Title" ASC';
    $viewParams = ['roles' => \event\models\Role::model()->findAll($criteria)];

    $showInviteRequests = \event\models\Widget::model()
      ->byEventId($this->getEvent()->Id)->byName('event\widgets\InviteRequest')->exists();
    if ($showInviteRequests)
    {
      $filter = new \partner\models\forms\user\InviteRequestFilter();
      $filter->attributes = $request->getParam(get_class($filter));
      
      $criteria = new \CDbCriteria();
      $criteria->order = '"t"."CreationTime" DESC';
      $criteria->with  = ['User'];
      
      if ($filter->validate())
      {
        $criteria->mergeWith($filter->getCriteria());
      }
      
      $paginator = new \application\components\utility\Paginator(\event\models\InviteRequest::model()->byEventId($this->getEvent()->Id)->count($criteria));
      $paginator->perPage = \Yii::app()->params['PartnerInviteRequestPerPage'];
      $criteria->mergeWith($paginator->getCriteria());
      
      $viewParams['inviteRequests'] = \event\models\InviteRequest::model()->byEventId($this->getEvent()->Id)->findAll($criteria);
      $viewParams['filter'] = $filter;
      $viewParams['paginator'] = $paginator;
    }
    $viewParams['showInviteRequests'] = $showInviteRequests;
    
    $this->getController()->setPageTitle('Приглашения');
    $this->getController()->initActiveBottomMenu('invite');
    $this->getController()->render('invite', $viewParams);
  }
  
  
  private function processGenerate()
  {
    $code = new \event\models\InviteCode();
    $code->EventId = $this->getEvent()->Id;
    $code->RoleId = \Yii::app()->getRequest()->getParam('RoleId');
    
    $text = new \application\components\utility\Texts();
    $code->Code = $text->getUniqString($this->getEvent()->Id);   
    $code->save();
    
    $result = new \stdClass();
    $result->success = true;
    $result->invite  = $this->getController()->createAbsoluteUrl('/event/invite/index', array('code' => $code->Code, 'idName' => $this->getEvent()->IdName));
    echo json_encode($result);
    \Yii::app()->end();
  }
  
  
  private function processApproved($approved)
  {
    $request = \Yii::app()->getRequest();
    $inviteRequest  = \event\models\InviteRequest::model()->byEventId($this->getEvent()->Id)
      ->findByPk($request->getParam('InviteId'));
    if ($inviteRequest == null)
      throw new \CHttpException(404);
    
    $inviteRequest->Approved = $approved;
    $inviteRequest->ApprovedTime = date('d-m-Y H:i:s');
    $inviteRequest->save();
    
    if ($approved == \event\models\Approved::Yes)
    {
      $role = \event\models\Role::model()->findByPk($request->getParam('RoleId'));
      if (empty($this->getEvent()->Parts))
        $this->getEvent()->registerUser($inviteRequest->User, $role);
      else
        $this->getEvent()->registerUserOnAllParts($inviteRequest->User, $role);
    }
    
    $this->getController()->refresh();
  }
}
