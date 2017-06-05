<?php
namespace mail\components\filter;

use event\models\Part;

class Event implements IFilter
{
    /** @var EventCondition[] */
    public $positive = [];

    /** @var EventCondition[] */
    public $negative = [];

    private $criteria;

    public function getCriteria()
    {
        $this->criteria = new \CDbCriteria();
        if (!empty($this->positive)) {
            $this->fillCriteria($this->positive);
        }

        if (!empty($this->negative)) {
            $this->fillCriteria($this->negative, false);
        }

        if (count($this->positive) == 1 && (empty($this->negative) || (count($this->negative) == 1 && $this->positive[0]->eventId == $this->negative[0]->eventId))) {
            $this->criteria->with = [
                'Participants' => ['together' => true, 'on' => '"Participants"."EventId" = :EventId_'.$this->positive[0]->eventId]
            ];
        } else {
            $this->criteria->with = ['Participants'];
        }
        return $this->criteria;
    }

    private function fillCriteria($conditions, $in = true)
    {
        $command = \Yii::app()->getDb()->createCommand();
        $command->select('UserId')->from('EventParticipant');
        foreach ($conditions as $condition) {
            $part = ['and', '"EventId" = :EventId_'.$condition->eventId];
            if (count($condition->roles) > 0) {
                if (!$in && Part::model()->byEventId($condition->eventId)->exists()) {
                    $command2 = \Yii::app()->getDb()->createCommand()
                        ->select('UserId')->from('EventParticipant')
                        ->where(['not in', 'RoleId', $condition->roles])->andWhere('"EventId" = :EventId_'.$condition->eventId);
                    $part[] = ['and', '"UserId" NOT IN ('.$command2->getText().')'];
                }
                $part[] = ['in', 'RoleId', $condition->roles];
            }

            $command->orWhere($part);
            $this->criteria->params['EventId_'.$condition->eventId] = $condition->eventId;
        }

        $this->criteria->addCondition('"t"."Id" '.(!$in ? 'NOT' : '').' IN ('.$command->getText().')');
    }
}