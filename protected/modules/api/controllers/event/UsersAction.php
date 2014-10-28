<?php
namespace api\controllers\event;


class UsersAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $maxResults = (int)$request->getParam('MaxResults', $this->getMaxResults());
    $maxResults = min($maxResults, $this->getMaxResults());
    $pageToken = $request->getParam('PageToken', null);
    $roles = $request->getParam('RoleId');

    $command = \Yii::app()->getDb()->createCommand()
        ->select('EventParticipant.UserId')->from('EventParticipant')
        ->where('"EventParticipant"."EventId" = '.$this->getEvent()->Id);
    if (!empty($roles))
      $command->andWhere(array('in', 'EventParticipant.RoleId', $roles));

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
      'Participants' => array('on' => '"Participants"."EventId" = :EventId', 'params' => array(
        'EventId' => $this->getEvent()->Id
      ), 'together' => false),
      'Employments.Company' => array('on' => '"Employments"."Primary"', 'together' => false),
      'LinkPhones.Phone' => array('together' => false)
    );
    $criteria->order = '"t"."LastName" ASC, "t"."FirstName" ASC';



    $criteria->addCondition('"t"."Id" IN ('.$command->getText().')');

    $users = \user\models\User::model()->findAll($criteria);

    $result = [];
    $result['Users'] = [];
    foreach ($users as $user)
    {
      $this->getAccount()->getDataBuilder()->createUser($user);
        if ($this->getAccount()->Role != 'mobile') {
            $this->getAccount()->getDataBuilder()->buildUserContacts($user);
        }
      $this->getAccount()->getDataBuilder()->buildUserEmployment($user);
      $result['Users'][] = $this->getAccount()->getDataBuilder()->buildUserEvent($user);
    }

    if (count($users) === $maxResults)
    {
      $result['NextPageToken'] = $this->getController()->getPageToken($criteria->offset + $maxResults);
    }

    $this->getController()->setResult($result);
  }
}