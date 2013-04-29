<?php
namespace api\controllers\event;


class UsersAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $maxResults = $request->getParam('MaxResults', $this->getMaxResults());
    $maxResults = min($maxResults, $this->getMaxResults());
    $pageToken = $request->getParam('PageToken', null);

    $criteria = new \CDbCriteria();
    if ($pageToken === null)
    {
      $criteria->limit = $maxResults;
      $criteria->offset = 0;
    }
    else
    {
      $criteria->limit = $maxResults;
      $criteria->offset = $this->getController()->parsePageToken($pageToken);
    }

    $criteria->with = array(
      'Employments.Company' => array('on' => '"Employments"."Primary"', 'together' => false),
      'Participants' => array('together' => true)
    );

    $criteria->addCondition('"Participants"."EventId" = :EventId');
    $criteria->params['EventId'] = $this->getEvent()->Id;

    $users = \user\models\User::model()->findAll($criteria);

    $result = array();
    $result['Users'] = array();
    foreach ($users as $user)
    {
      $this->getAccount()->getDataBuilder()->createUser($user);
      $this->getAccount()->getDataBuilder()->buildUserContacts($user);
      $this->getAccount()->getDataBuilder()->buildUserEmployment($user);
      $result['Users'][] = $this->getAccount()->getDataBuilder()->buildUserEvent($user);
    }

    if (sizeof($users) === $maxResults)
    {
      $result['NextPageToken'] = $this->getController()->getPageToken($criteria->offset + $maxResults);
    }

    $this->getController()->setResult($result);
  }
}