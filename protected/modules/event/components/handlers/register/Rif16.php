<?php
namespace event\components\handlers\register;

use event\models\Role;

class Rif16 extends Base
{
    /**
     * @inheritDoc
     */
    public function getBody()
    {
        if ($this->role->Id == Role::VIRTUAL_ROLE_ID) {
            return parent::getBody();
        }

        $params = [
            'user' => $this->user,
            'event' => $this->event,
            'participant' => $this->participant,
            'role' => $this->role
        ];
        return $this->renderBody('event.views.mail.register.rif16', $params);
    }

}