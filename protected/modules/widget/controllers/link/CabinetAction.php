<?php
namespace widget\controllers\link;

class CabinetAction extends \widget\components\Action
{
  public function run()
  {
    if (\Yii::app()->getRequest()->getIsAjaxRequest())
    {
      $this->processAjaxRequest();
    }

    $userId = \Yii::app()->getUser()->getId();

    $criteria = new \CDbCriteria();
    $criteria->addCondition('"t"."Approved" != -1');
    $criteria->addCondition('"t"."EventId" = :EventId');
    $criteria->params['EventId'] = $this->getEvent()->Id;
    $criteria->order = '"t"."MeetingTime" ASC, "t"."CreationTime" ASC';
    $criteria->with  = [
      'User.Employments' => ['together' => false,'with' => ['Company']],
      'User.Settings' => ['alias' => 'SettingsUser'],
      'Owner.Employments' => ['together' => false,'with' => ['Company']],
      'Owner.Settings' => ['alias' => 'SettingsOwner'],
    ];

    $schedule = new \stdClass();
    $schedule->links = [];
    $schedule->notDistributedLinks = [];

    $links = \link\models\Link::model()->byAnyUserId($userId)->findAll($criteria);
    /** @var \link\models\Link $link */
    foreach($links as $link)
    {
      if ($link->Approved == \event\models\Approved::None && $link->OwnerId == $userId)
        $schedule->notDistributedLinks[] = $link;
      else if ($link->Approved == \event\models\Approved::Yes)
        $schedule->links[] = $link;
    }

    \Yii::app()->getClientScript()->registerMetaTag($this->getEvent()->getFormattedStartDate('MM/dd/yyyy'),'EventStartDate');
    \Yii::app()->getClientScript()->registerMetaTag($this->getEvent()->getFormattedEndDate('MM/dd/yyyy'),'EventEndDate');
    $this->getController()->render('cabinet', [
      'schedule' => $schedule,
      'formDatetime' => new \link\models\forms\Datetime()
    ]);
  }

  private function processAjaxRequest()
  {
    $request = \Yii::app()->getRequest();
    $action = $request->getParam('action');
    $link = \link\models\Link::model()->byOwnerId(\Yii::app()->getUser()->getId())->findByPk($request->getParam('linkId'));

    $method  = 'processAjaxAction'.ucfirst($action);
    if (method_exists($this, $method) || $link == null)
    {
      $result = $this->$method($link);
      echo json_encode($result);
      \Yii::app()->end();
    }
    else
      throw new \CHttpException(404);
  }

  private function processAjaxActionReject(\link\models\Link $link)
  {
    $link->Approved = \event\models\Approved::No;
    $link->save();
    return ['success' => true];
  }

  private function processAjaxActionSetDatetime(\link\models\Link $link)
  {
    $result = new \stdClass();

    $request = \Yii::app()->getRequest();
    $form = new \link\models\forms\Datetime();
    $form->attributes = $request->getParam(get_class($form));
    if ($form->validate())
    {
      $link->Approved = \event\models\Approved::Yes;
      $link->MeetingTime = date('Y-m-d H:i:s', strtotime($form));
      $link->save();
      $result->success = true;
    }
    else
    {
      $result->error = $form->getErrors();
    }
    return $result;
  }
} 