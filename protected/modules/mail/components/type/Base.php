<?php
namespace mail\components\type;

abstract class Base
{
    protected $user;

    function __construct(\user\models\User $user)
    {
        $this->user = $user;
    }

    /**
     * @return array
     */
    public abstract function getTemplateParams();

}