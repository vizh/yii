<?php
namespace mail\components\mail;

class Mblt13 extends \mail\components\Mail
{
    public $user = null;

    public function isHtml()
    {
        return true;
    }

    public function getFrom()
    {
        return 'users@runet-id.com';
    }

    public function getFromName()
    {
        return '—RUNET—ID—';
    }

    public function getSubject()
    {
        return 'Электронный билет #MBLT13';
    }

    public function getBody()
    {
        $role = $this->user->Participants[0]->Role;
        return \Yii::app()->getController()->renderPartial('mail.views.partner.mblt13-1', ['user' => $this->user, 'role' => $role], true);
    }
}
