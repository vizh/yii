<?php


class EventController extends ruvents\components\Controller
{

  /**
   *
   */
  public function actionUsers()
  {
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


  private function saveLogs()
  {
    $logger = Yii::GetLogger();
    ob_start();
    $logs = $logger->getProfilingResults();
    print_r($logs);
    $log = ob_get_clean();

    $executionTime = $logger->getExecutionTime();

    $file = fopen('ruventslog.log', 'a+');

    fwrite($file, $executionTime . "\n");
    fwrite($file, $log . "\n\n\n");

    fclose($file);
  }

  /**
   *
   * @throws \ruvents\components\Exception
   */
  public function actionRegister()
  {
    $request = \Yii::app()->getRequest();
    $rocId = $request->getParam('RocId', null);
    $roleId = $request->getParam('RoleId', null);
    $dayId = \ruvents\components\DataBuilder::RadDayId();

    $event = \event\models\Event::GetById($this->Operator()->EventId);
    if (empty($event))
    {
      throw new \ruvents\components\Exception(301);
    }
    $user = \user\models\User::GetByRocid($rocId);
    if (empty($user))
    {
      throw new \ruvents\components\Exception(202, array($rocId));
    }

    $role = \event\models\Role::GetById($roleId);
    if (empty($role))
    {
      throw new \ruvents\components\Exception(302);
    }

    $day = null;
    try
    {
      if (empty($event->Days))
      {
        $participant = $event->RegisterUser($user, $role);
      }
      else
      {
        foreach ($event->Days as $eDay)
        {
          if ($eDay->DayId == $dayId)
          {
            $day = $eDay;
            break;
          }
        }
        if ($day == null)
        {
          throw new \ruvents\components\Exception(306, array($dayId));
        }
        $participant = $event->RegisterUserOnDay($day, $user, $role);
      }
    }
    catch(Exception $e)
    {
      throw new \ruvents\components\Exception(100, array($e->getMessage()));
    }
    if (empty($participant))
    {
      throw new \ruvents\components\Exception(303);
    }

    $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('Role', 0, $participant->RoleId));
    if ($day !== null)
    {
      $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('Day', $day->DayId, $day->DayId));
    }
    $this->detailLog->UserId = $user->UserId;
    $this->detailLog->save();

    echo json_encode(array('Success' => true));
  }

  public function actionUnregister()
  {
    $request = \Yii::app()->getRequest();
    $rocId = $request->getParam('RocId', null);
    $dayId = \ruvents\components\DataBuilder::RadDayId();

    $event = \event\models\Event::GetById($this->Operator()->EventId);
    if (empty($event))
    {
      throw new \ruvents\components\Exception(301);
    }
    $user = \user\models\User::GetByRocid($rocId);
    if (empty($user))
    {
      throw new \ruvents\components\Exception(202, array($rocId));
    }

    $participant = \event\models\Participant::model()->byEventId($event->EventId)->byUserId($user->UserId);
    $day = null;
    if (!empty($event->Days))
    {
      foreach ($event->Days as $eDay)
      {
        if ($eDay->DayId == $dayId)
        {
          $day = $eDay;
          break;
        }
      }
      if ($day == null)
      {
        throw new \ruvents\components\Exception(306, array($dayId));
      }

      $participant->byDayId($day->DayId);
    }
    else
    {
      $participant->byDayNull();
    }

    $participant = $participant->find();
    if (empty($participant))
    {
      throw new \ruvents\components\Exception(304);
    }

    $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('Role', $participant->RoleId, 0));
    if ($day !== null)
    {
      $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('Day', $day->DayId, $day->DayId));
    }
    $this->detailLog->UserId = $user->UserId;
    $this->detailLog->save();

    $participant->delete();
    echo json_encode(array('Success' => true));
  }

  /**
   *
   */
  public function actionChangerole()
  {
    $request = \Yii::app()->getRequest();
    $rocId = $request->getParam('RocId', null);
    $roleId = $request->getParam('RoleId', null);
    $dayId = \ruvents\components\DataBuilder::RadDayId();

    $event = \event\models\Event::GetById($this->Operator()->EventId);
    if (empty($event))
    {
      throw new \ruvents\components\Exception(301);
    }

    $user = \user\models\User::GetByRocid($rocId);
    if (empty($user))
    {
      throw new \ruvents\components\Exception(202, array($rocId));
    }

    $role = \event\models\Role::GetById($roleId);
    if (empty($role))
    {
      throw new \ruvents\components\Exception(302);
    }

    $participant = \event\models\Participant::model()->byEventId($event->EventId)->byUserId($user->UserId);
    $day = null;
    if (!empty($event->Days))
    {
      foreach ($event->Days as $eDay)
      {
        if ($eDay->DayId == $dayId)
        {
          $day = $eDay;
          break;
        }
      }
      if ($day == null)
      {
        throw new \ruvents\components\Exception(306, array($dayId));
      }

      $participant->byDayId($day->DayId);
    }
    else
    {
      $participant->byDayNull();
    }

    /** @var $participant \event\models\Participant */
    $participant = $participant->find();
    if (empty($participant))
    {
      throw new \ruvents\components\Exception(304);
    }
    if ($participant->RoleId == $role->RoleId)
    {
      if ($participant->RoleId == 1)
      {
        echo json_encode(array('Success' => true));
        return;
      }
      throw new \ruvents\components\Exception(305);
    }

    $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('Role', $participant->RoleId, $role->RoleId));
    if ($day !== null)
    {
      $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('Day', $day->DayId, $day->DayId));
    }
    $this->detailLog->UserId = $user->UserId;
    $this->detailLog->save();

    $participant->UpdateRole($role);

    echo json_encode(array('Success' => true));
  }

  /**
   *
   */
  public function actionRoles ()
  {
    $request = \Yii::app()->getRequest();
    $dayId = \ruvents\components\DataBuilder::RadDayId();

    $event = \event\models\Event::GetById($this->Operator()->EventId);
    if (empty($event))
    {
      throw new \ruvents\components\Exception(301);
    }

    $participantsModel = \event\models\Participant::model()->byEventId($event->EventId);

    if (!empty($event->Days))
    {
      $day = null;
      foreach ($event->Days as $eDay)
      {
        if ($eDay->DayId == $dayId)
        {
          $day = $eDay;
          break;
        }
      }

      if ($day == null)
      {
        throw new \ruvents\components\Exception(306, array($dayId));
      }
      $participantsModel->byDayId($day->DayId);
    }
    else
    {
      $participantsModel->byDayNull();
    }

    $criteria = new \CDbCriteria();
    $criteria->group = 't.RoleId';
    $criteria->with  = array('Role');
    $criteria->order = 'Role.Priority DESC';

    $participants = $participantsModel->findAll($criteria);
    $result = array();
    foreach ($participants as $participant)
    {
      $result['Roles'][] = $this->DataBuilder()->CreateRole($participant->Role);
    }
    echo json_encode($result);
  }

  /**
   *
   */
  public function actionSettings()
  {
    $event = \event\models\Event::GetById($this->Operator()->EventId);
    if (empty($event))
    {
      throw new \ruvents\components\Exception(301);
    }

    $result = array('Settings' => array());
    $settings = \ruvents\models\EventSetting::model()->byEventId($event->EventId)->findAll();
    foreach ($settings as $setting)
    {
      $result['Settings'][] = $this->DataBuilder()->{$setting->DataBuilder}($setting);
    }
    echo json_encode($result);
  }
}
