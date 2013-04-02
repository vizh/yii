<?php
namespace ruvents\controllers\event;

class RolesAction extends \ruvents\components\Action
{
  public function run()
  {
    //todo:

    throw new \application\components\Exception('Not implement yet');

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
}
