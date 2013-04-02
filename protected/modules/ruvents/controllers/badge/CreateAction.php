<?php
namespace ruvents\controllers\badge;

class CreateAction extends \ruvents\components\Action
{
  public function run()
  {
    //todo:

    throw new \application\components\Exception('Not implement yet');


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

    /** @var $participant \event\models\Participant */
    $participant = $participant->find();
    if (empty($participant))
    {
      throw new \ruvents\components\Exception(304);
    }
    $participant->UpdateTime = time();
    $participant->save();

    $badge->RoleId = $participant->RoleId;
    $badge->CreationTime = date('Y-m-d H:i:s');
    $badge->save();

    echo json_encode(array('Success' => true));
  }
}
