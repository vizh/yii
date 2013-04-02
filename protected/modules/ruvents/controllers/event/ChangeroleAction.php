<?php
namespace ruvents\controllers\event;

class ChangeroleAction extends \ruvents\components\Action
{
  public function run()
  {
    //todo:

    throw new \application\components\Exception('Not implement yet');


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
}
