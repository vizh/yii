<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alaris
 * Date: 8/15/12
 * Time: 10:19 PM
 * To change this template use File | Settings | File Templates.
 */
class BadgeController extends ruvents\components\Controller
{
  public function actionList()
  {
    $request = \Yii::app()->getRequest();
    $rocId = $request->getParam('RocId', null);
    $dayId = $request->getParam('DayId');

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

    $badge = \ruvents\models\Badge::model()->byEventId($event->EventId)->byUserId($user->UserId);
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


      $badge->byDayId($day->DayId);
    }
    else
    {
      $badge->byDayNull();
    }

    $badges = $badge->with(array('Role', 'User'))->findAll();

    $result = array();
    foreach ($badges as $badge)
    {
      $result[] = $this->DataBuilder()->CreateBadge($badge);
    }

    echo json_encode($result);
  }

  public function actionCreate()
  {
    $request = \Yii::app()->getRequest();
    $rocId = $request->getParam('RocId', null);
    $dayId = $request->getParam('DayId');

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

    $badge = new \ruvents\models\Badge();
    $badge->OperatorId = $this->Operator()->OperatorId;
    $badge->EventId = $event->EventId;
    $badge->UserId = $user->UserId;

    $participant = \event\models\Participant::model()->byEventId($event->EventId)->byUserId($user->UserId);
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

      $badge->DayId = $day->DayId;
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

    $badge->RoleId = $participant->RoleId;
    $badge->CreationTime = date('Y-m-d H:i:s');
    $badge->save();

    echo json_encode(array('Success' => true));
  }
}