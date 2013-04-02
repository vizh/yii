<?php
namespace ruvents\controllers\event;

class UnregisterAction extends \ruvents\components\Action
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
}
