<?php
namespace mail\components\filter;

class EventCondition
{
    public $eventId;
    public $roles = [];

    /**
     * @param int $eventId
     * @param int[] $roles
     */
    function __construct($eventId, $roles = [])
    {
        $this->eventId = $eventId;
        $this->roles = $roles;
    }

}