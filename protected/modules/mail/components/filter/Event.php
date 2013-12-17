<?php
namespace mail\components\filter;

class Event
{
  /** @var EventCondition[]  */
  public $positive = [];

  /** @var EventCondition[]  */
  public $negative = [];


  private $criteria;
  public function getCriteria()
  {
    $this->criteria = new \CDbCriteria();
    if (!empty($this->positive))
    {
      $this->fillCriteria($this->positive);
    }

    if (!empty($this->negative))
    {
      $this->fillCriteria($this->negative, false);
    }

    if (count($this->positive) == 1 && empty($this->negative))
    {
      $this->criteria->with = [
        'Participants' => ['together' => true, 'on' => '"Participants"."EventId" = :EventId_'.$this->positive[0]->eventId]
      ];
    }
    else
    {
      $this->criteria->with = ['Participants'];
    }
    return $this->criteria;
  }

  private function fillCriteria($conditions, $in = true)
  {
    $command = \Yii::app()->getDb()->createCommand();
    $command->select('UserId')->from('EventParticipant');
    foreach ($conditions as $condition)
    {
      $part =  ['and', '"EventId" = :EventId_'.$condition->eventId];
      if (count($condition->roles) > 0)
      {
        $part[] = ['in', 'RoleId', $condition->roles];
      }
      $command->orWhere($part);
      $this->criteria->params['EventId_'.$condition->eventId] = $condition->eventId;
    }
    $this->criteria->addCondition('"t"."Id" '.(!$in ? 'NOT' : '').' IN (' . $command->getText(). ')');
  }
}