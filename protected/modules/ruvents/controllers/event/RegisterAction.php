<?php
namespace ruvents\controllers\event;

class RegisterAction extends \ruvents\components\Action
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
}
