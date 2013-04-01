<?php
namespace ruvents\controllers\badge;

class ListAction extends \ruvents\components\Action
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
}
