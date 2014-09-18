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

    $filter = new \partner\models\forms\user\InviteRequestFilter();
    $filter->attributes = $request->getParam(get_class($filter));
    
    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."CreationTime" DESC';
    $criteria->with  = ['Owner', 'Sender'];
    if ($filter->validate())
    {
      $criteria->mergeWith($filter->getCriteria());
    }
    $paginator = new \application\components\utility\Paginator(\event\models\InviteRequest::model()->byEventId($this->getEvent()->Id)->count($criteria));
    $paginator->perPage = \Yii::app()->params['PartnerInviteRequestPerPage'];
    $criteria->mergeWith($paginator->getCriteria());
    $inviteRequests = \event\models\InviteRequest::model()->byEventId($this->getEvent()->Id)->findAll($criteria);
    $showGenerateForm = \event\models\LinkWidget::model()->byEventId($this->getEvent()->Id)->byClassId(8)->exists();

    $this->getController()->setPageTitle('Приглашения');
    $this->getController()->initActiveBottomMenu('invite');
    $this->getController()->render('invite', 
      ['inviteRequests' => $inviteRequests, 'event' => $this->getEvent(), 'filter' => $filter, 'paginator' => $paginator, 'roles' => $this->getEvent()->getRoles(), 'showGenerateForm' => $showGenerateForm]
    );
  }
  
  
  private function processGenerate()
  {
    $code = new \event\models\Invite();
    $code->EventId = $this->getEvent()->Id;
    $code->RoleId = \Yii::app()->getRequest()->getParam('RoleId');
    
    $text = new \application\components\utility\Texts();
    $code->Code = $text->getUniqString($this->getEvent()->Id);   
    $code->save();
    
    $result = new \stdClass();
    $result->success = true;
    $result->invite  = $code->Code;
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
    
    $role = null;
    if ($approved == \event\models\Approved::Yes)
      $role = \event\models\Role::model()->findByPk($request->getParam('RoleId'));
    
    $inviteRequest->changeStatus($approved, $role); 
    $this->getController()->refresh();
  }
}
