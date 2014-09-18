<?php
namespace event\components\handlers\invite\disapprove;

class Svmr14 extends Base
{
    public function getSubject()
    {
        return 'Конференция «Silicon Valley Meets Russia»';
    }

    public function getBody()
    {
        return $this->renderBody('event.views.mail.invite.disapprove.svmr14', ['user' => $this->user]);
    }
} 