<?php
namespace event\components\handlers\invite\disapprove;

class Rif14 extends Base
{
    /**
     * @return string
     */
    public function getFrom()
    {
        return 'pr@raec.ru';
    }

    /**
     * @return string
     */
    public function getFromName()
    {
        return 'Пресс-служба RIW';
    }

    public function getSubject()
    {
        return 'Ваша заявка как представитель СМИ на RIW 2014 была отклонена';
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->renderBody('event.views.mail.invite.disapprove.riw14', ['user' => $this->user]);
    }
}