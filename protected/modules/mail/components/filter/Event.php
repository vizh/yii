<?php
namespace mail\components\filter;

class Event
{
  /** @var EventCondition[]  */
  public $positive = [];

  /** @var EventCondition[]  */
  public $negative = [];

  public function getCriteria()
  {
    $result = new \CDbCriteria();

    if (count($this->positive) > 0)
    {
      $result->with = ['Participants' => ['together' => true]];
      foreach ($this->positive as $cond)
      {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('"Participants"."EventId" = :EventId'.$cond->eventId);
        $criteria->params['EventId'.$cond->eventId] = $cond->eventId;
        if (count($cond->roles) > 0)
        {
          $criteria->addInCondition('"Participants"."RoleId"', $cond->roles);
        }
        $result->mergeWith($criteria, 'OR');
      }
    }

    if (count($this->negative) > 0)
    {
      $command = \Yii::app()->getDb()->createCommand();
      $command->select('UserId')->from('EventParticipant');
      foreach ($this->negative as $cond)
      {
        $part = ['and',
          ['EventId = :NegEventId'.$cond->eventId, ['NegEventId'.$cond->eventId => $cond->eventId]]
        ];
        if (count($cond->roles) > 0)
        {
          $part[] = ['in', 'RoleId', $cond->roles];
        }
        $command->orWhere($part);
      }
      $result->addCondition('"t"."Id" NOT IN (' . $command->getText(). ')');
    }

    return $result;
  }
}