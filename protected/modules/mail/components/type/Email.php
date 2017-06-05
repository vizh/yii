<?php
namespace mail\components\type;

class Email extends Base
{

    /**
     * @return array
     */
    public function getTemplateParams()
    {
        return ['email' => $this->user->Email];
    }
}