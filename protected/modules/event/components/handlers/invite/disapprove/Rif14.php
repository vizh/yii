<?php
namespace event\components\handlers\invite\disapprove;

class Rif14 extends Base
{
    /**
     * @return string
     */
    public function getFrom()
    {
        return 'pr@rif.ru';
    }

    /**
     * @return string
     */
    public function getFromName()
    {
        return 'Пресс-служба РИФ+КИБ';
    }

    public function getSubject()
    {
        return 'Ваша заявка как представитель СМИ на форум "РИФ+КИБ 2014" была отклонена';
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->renderBody('event.views.mail.invite.disapprove.rif14', ['user' => $this->user]);
    }
}