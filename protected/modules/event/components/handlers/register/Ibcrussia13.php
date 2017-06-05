<?php
namespace event\components\handlers\register;

class Ibcrussia13 extends Base
{
    public function getSubject()
    {
        return 'Путевой лист IBC Russia 2013';
    }

    public function getHashSolt()
    {
        return $this->role->Id;
    }

    protected function getRepeat()
    {
        return false;
    }

    public function getBody()
    {
        if ($this->role->Id == 24 || $this->role->Id == 26) {
            return null;
        }

        return $this->renderBody('event.views.mail.register.ibcrussia13', [
            'user' => $this->user,
            'role' => $this->role,
            'participant' => $this->participant
        ]);
    }
} 