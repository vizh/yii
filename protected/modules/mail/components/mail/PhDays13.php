<?php
namespace mail\components\mail;

class PhDays13 extends \mail\components\Mail
{
    public $user = null;
    public $role = null;

    public function getFrom()
    {
        return 'user@runet-id.com';
    }

    public function getFromName()
    {
        return 'RUNET-ID';
    }

    public function getSubject()
    {
        return 'Электронный билет на Positive Hack Days 2013 / Electronic Ticket on Positive Hack Days 2013';
    }

    public function getAttachments()
    {
        $ruTicketPath = \Yii::getPathOfAlias('mail.tmp').'/phdays13_'.$this->user->RunetId.'_ru.html';
        $enTicketPath = \Yii::getPathOfAlias('mail.tmp').'/phdays13_'.$this->user->RunetId.'_en.html';

        \Yii::app()->setLanguage('ru');
        file_put_contents($ruTicketPath, \Yii::app()->getController()->renderPartial('mail.views.partner.phdays13-2_ru', ['user' => $this->user, 'role' => $this->role], true));

        \Yii::app()->setLanguage('en');
        file_put_contents($enTicketPath, \Yii::app()->getController()->renderPartial('mail.views.partner.phdays13-2_en', ['user' => $this->user, 'role' => $this->role], true));

        \Yii::app()->setLanguage('ru');

        return [
            'Электронный билет.html' => $ruTicketPath,
            'Electronic Ticket.html' => $enTicketPath
        ];
    }

    public function getBody()
    {
        return \Yii::app()->getController()->renderPartial('mail.views.partner.phdays13-2', ['user' => $this->user], true);
    }
}
