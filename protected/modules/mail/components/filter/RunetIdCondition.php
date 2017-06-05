<?php
namespace mail\components\filter;

class RunetIdCondition
{
    public $runetIdList = [];

    /**
     * @param string[] $roles
     */
    function __construct($runetIdList = [])
    {
        $this->runetIdList = $runetIdList;
    }
} 