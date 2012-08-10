<?php


class EventController extends ruvents\components\Controller
{
  public function actionUsers()
  {
    $request = \Yii::app()->getRequest();
    $query = $request->getParam('Query', null);
    $pageToken = $request->getParam('PageToken', null);
    $updateTime = $request->getParam('FromUpdateTime', null);

    if (strlen($query) != 0)
    {
      $criteria = \user\models\User::GetSearchCriteria($query);
    }
    else
    {
      $criteria = new CDbCriteria();
    }

    $criteria->addCondition('Participants.EventId = :EventId');
    $criteria->params[':EventId'] = $this->Operator()->EventId;

    if ($pageToken === null)
    {
      $criteria->limit = self::MaxResult;
      $criteria->offset = 0;
    }
    else
    {
      $criteria->limit = self::MaxResult;
      $criteria->offset = $this->ParsePageToken($pageToken);
    }

    $userModel = \user\models\User::model()->with(array(
      'Settings',
      'Employments.Company' => array('on' => 'Employments.Primary = :Primary', 'params' => array(':Primary' => 1)),
      'Participants' => array('together' => true),
      'Participants.Role',
      'Emails'
    ));

    if ($updateTime === null)
    {
      $criteria->order = 'Participants.EventUserId ASC';
    }
    else
    {
      $criteria->addCondition('Participants.UpdateTime > :UpdateTime');
      $criteria->params['UpdateTime'] = $updateTime;
      $criteria->order = 'Participants.UpdateTime ASC';
    }

    $users = $userModel->findAll($criteria);

    $result = array();
    foreach ($users as $user)
    {
      $this->DataBuilder()->CreateUser($user);
      $this->DataBuilder()->BuildUserEmail($user);
      $this->DataBuilder()->BuildUserEmployment($user);
      $result['Users'][] = $this->DataBuilder()->BuildUserEvent($user);
    }

    if (sizeof($users) == self::MaxResult)
    {
      $result['NextPageToken'] = $this->GetPageToken($criteria->offset + self::MaxResult);
    }

    //echo json_encode($result);
    echo '<pre>';
    print_r($result);
    echo '</pre>';
  }


}
