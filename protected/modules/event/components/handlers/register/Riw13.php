<?php
namespace event\components\handlers\register;

class Riw13 extends Base
{
    public function getFrom()
    {
        return 'users@russianinternetweek.ru';
    }

    public function getSubject()
    {
        return 'Вы успешно зарегистрировались на шестую ежегодную Неделю Российского Интернета (RIW-2013)';
    }

    public function getBody()
    {
        return $this->renderBody('event.views.mail.register.riw13', ['user' => $this->user, 'role' => $this->role]);
    }
}
