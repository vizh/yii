<?php
namespace mail\components\mail;

class Download13 extends \mail\components\Mail
{
    public $user = null;

    public function getTo()
    {
        return $this->user->Email;
    }

    public function getFrom()
    {
        return 'event@runet-id.com';
    }

    public function getFromName()
    {
        return 'RUNET-ID';
    }

    public function isHtml()
    {
        return true;
    }

    public function getSubject()
    {
        return 'Конференция Право на DownLoad: путевой лист';
    }

    public function getBody()
    {
        $role = $this->user->Participants[0]->Role;
        return \Yii::app()->getController()->renderPartial('mail.views.partner.download13-1', ['user' => $this->user, 'role' => $role], true);
    }

}

?>
