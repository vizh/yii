<?php
namespace event\components\handlers\register;

class Fpsb13 extends Base
{
    public function getSubject()
    {
        return 'Путевой лист III Инновационный форум Промсвязьбанка';
    }

    public function getBody()
    {
        return $this->renderBody('event.views.mail.register.fpsb13', ['user' => $this->user, 'participant' => $this->participant]);
    }
}
