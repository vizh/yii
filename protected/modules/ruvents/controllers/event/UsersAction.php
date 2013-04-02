<?php
namespace ruvents\controllers\event;

class UsersAction extends \ruvents\components\Action
{
  public function run()
  {
    //todo:

    throw new \application\components\Exception('Not implement yet');

    ini_set("memory_limit", "512M");

    $request = \Yii::app()->getRequest();
    $query = $request->getParam('Query', null);
    $pageToken = $request->getParam('PageToken', null);
    $updateTime = $request->getParam('FromUpdateTime', null);
    $returnBadgeCount = (bool) $request->getParam('ReturnBadgeCount', false);

    if (strlen($query) != 0)
    {
      $criteria = \user\models\User::GetSearchCriteria($query);
    }
    else
    {
      $criteria = new CDbCriteria();
    }

    $criteria->select = 't.UserId';

    $criteria->addCondition('Participants.EventId = :EventId');
    $criteria->params[':EventId'] = $this->Operator()->EventId;

    $offset = 0;
    if ($pageToken !== null)
    {
      $offset = $this->ParsePageToken($pageToken);
    }
    $criteria->limit = self::MaxResult;
    $criteria->offset = $offset;

    if ($updateTime === null)
    {
      $criteria->order = 'Participants.EventUserId ASC';
    }
    else
    {
      $criteria->addCondition('Participants.UpdateTime > :UpdateTime');
      $criteria->params['UpdateTime'] = strtotime($updateTime);
      $criteria->order = 'Participants.UpdateTime ASC';
    }

    $criteria->group = 't.UserId';

    $userModel = \user\models\User::model()->with(array(
      'Participants' => array('together' => true, 'select' => false),
      'Settings' => array('together' => true, 'select' => false),
    ));

    /** @var $users User[] */
    $users = $userModel->findAll($criteria);
    $idList = array();
    foreach ($users as $user)
    {
      $idList[] = $user->UserId;
    }

    $criteria = new CDbCriteria();
    $criteria->addInCondition('t.UserId', $idList);

    $userModel = \user\models\User::model()->with(array(
      'Employments.Company' => array('on' => 'Employments.Primary = :Primary', 'params' => array(':Primary' => 1)),
      'Participants' => array('on' => 'Participants.EventId = :EventId', 'params' => array(':EventId' => $this->Operator()->EventId)),
      'Participants.Role',
      'Emails',
      'Phones'
    ));

    /** @var $users User[] */
    $users = $userModel->findAll($criteria);

    if ($returnBadgeCount)
    {
      $badges = \ruvents\models\Badge::model()->findAll('t.EventId = :EventId', array(':EventId' => $this->Operator()->EventId));
      $badgesCount = array();
      foreach ($badges as $badge)
      {
        $badgesCount[$badge->UserId]++;
      }
    }

    $result = array();
    foreach ($users as $user)
    {
      $this->DataBuilder()->CreateUser($user);
      $this->DataBuilder()->BuildUserEmail($user);
      $this->DataBuilder()->BuildUserEmployment($user);
      $this->DataBuilder()->BuildUserPhone($user);
      $buildUser = $this->DataBuilder()->BuildUserEvent($user);

      if ($returnBadgeCount)
      {
        $buildUser->BadgeCount = isset($badgesCount[$user->UserId]) ? $badgesCount[$user->UserId] : 0;
      }

      $result['Users'][] = $buildUser;
    }

    if (sizeof($users) == self::MaxResult)
    {
      $result['NextPageToken'] = $this->GetPageToken($offset + self::MaxResult);
    }

    echo json_encode($result);
  }
}
