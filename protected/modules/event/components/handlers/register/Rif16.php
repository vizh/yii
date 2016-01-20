<?php
namespace event\components\handlers\register;

class Rif16 extends Base
{
    /**
     * @inheritDoc
     */
    public function getBody()
    {
        $params = [
            'user' => $this->user,
            'event' => $this->event,
            'participant' => $this->participant,
            'role' => $this->role
        ];
        return $this->renderBody('event.views.mail.register.rif16', $params);
    }

}