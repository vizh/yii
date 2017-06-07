<?php
namespace mail\components\type;

class Participant extends Base
{
    /**
     * @return array
     */
    public function getTemplateParams()
    {
        return ['user' => $this->user, 'participants' => $this->user->Participants];
    }
}