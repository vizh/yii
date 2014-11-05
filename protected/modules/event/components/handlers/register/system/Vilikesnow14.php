<?php
namespace event\components\handlers\register\system;


class Vilikesnow14 extends Base
{
    public function getFrom()
    {
        return 'info@vilikessnow.ru';
    }

    public function getTo()
    {
        return 'info@vilikessnow.ru';
    }

    public function getBody()
    {
        return $this->renderBody('event.views.mail.register.system.vilikesnow14', ['user' => $this->user, 'role' => $this->role]);
    }
} 