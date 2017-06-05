<?php
namespace mail\components\mail;

use mail\components\Mailer;

class Riw13 extends \mail\components\Mail
{
    protected $user;

    public function __construct(Mailer $mailer, \user\models\User $user)
    {
        parent::__construct($mailer);
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return 'users@russianinternetweek.ru';
    }

    public function getFromName()
    {
        return 'RIW 2013';
    }

    public function getSubject()
    {
        return 'RIW 2013: приглашаем к участию!';
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->user->Email;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->renderBody('mail.views.partner.riw13-5', ['user' => $this->user, 'registrationLink' => $this->getRegistrationLink()]);
    }

    public function getRegistrationLink()
    {
        $secret = 'xggMpIQINvHqR0QlZgZa';
        $hash = substr(md5($this->user->RunetId.$secret), 0, 16);
        return 'http://2013.russianinternetweek.ru/my/'.$this->user->RunetId.'/'.$hash.'/';
    }

}