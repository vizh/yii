<?php
namespace mail\components;

class Builder
{
    protected $criteria;

    public function __construct()
    {
        $this->criteria = new \CDbCriteria();
        $this->criteria->distinct = true;
        $this->criteria->with = [
            'Settings' => ['together' => true, 'select' => false]
        ];
        $this->criteria->addCondition('NOT "Settings"."UnsubscribeAll"');
    }

    private $events = [];
    private $eventsWithRoles = [];

    /**
     * @param $eventId
     * @param array $roles
     */
    public function addEvent($eventId, $roles = [])
    {
        if (sizeof($roles) == 0) {
            $this->events[] = $eventId;
        } else {
            $this->eventsWithRoles[$eventId] = $roles;
        }
    }

    /**
     * @return \CDbCriteria
     */
    public function getCriteria()
    {

        $eventCriteria = new \CDbCriteria();
        if (sizeof($this->events) > 0 || sizeof($this->eventsWithRoles) > 0) {
            $eventCriteria->with = [
                'Participants' => ['together' => true, 'select' => false]
            ];
        }
        if (sizeof($this->events) > 0) {
            $eventCriteria->addInCondition('"Participants"."EventId"', $this->events);
        }
        foreach ($this->eventsWithRoles as $eventId => $roles) {
            $criteria = new \CDbCriteria();
            $criteria->addCondition('"Participants"."EventId" = :EventId'.$eventId);
            $criteria->params['EventId'.$eventId] = $eventId;
            if (sizeof($roles) > 0) {
                $criteria->addInCondition('"Participants"."RoleId"', $roles);
            }
            $eventCriteria->mergeWith($criteria, 'OR');
        }
        $this->criteria->mergeWith($eventCriteria);

        return $this->criteria;
    }
}