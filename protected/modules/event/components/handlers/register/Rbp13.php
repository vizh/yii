<?php
namespace event\components\handlers\register;

class Rbp13 extends Base
{
    public function getSubject()
    {
        return 'Благодарим Вас, за регистрацию в RUSSIAN BUSINESS PARTY - Вечеринка в стиле Bond Party';
    }

    public function getBody()
    {
        return $this->renderBody('event.views.mail.register.rbp13', ['user' => $this->user, 'role' => $this->role]);
    }
}
