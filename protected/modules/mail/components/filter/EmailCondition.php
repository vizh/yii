<?php
namespace mail\components\filter;

class EmailCondition
{
    public $emails = [];

    /**
     * @param string[] $roles
     */
    function __construct($emails = [])
    {
        $this->emails = $emails;
    }
}