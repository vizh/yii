<?php
namespace mail\components\type;

class User extends Base
{
    /**
     * @return array
     */
    public function getTemplateParams()
    {
        return ['user' => $this->user];
    }
}