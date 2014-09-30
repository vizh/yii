<?php
namespace user\components\handlers\recover\mail;

use mail\components\Mailer;
use mail\components\MailLayout;

class Recover extends MailLayout
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
        return 'users@runet-id.com';
    }

    public function getFromName()
    {
        return 'RUNET-ID';
    }

    public function getSubject()
    {
        return \Yii::t('app', 'Восстановление пароля');
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->user->Email;
    }

    /**
     * @inheritdoc
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return bool
     */
    public function showUnsubscribeLink()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function getIsPriority()
    {
        return true;
    }

    public function getBody()
    {
        return $this->renderBody('user.views.mail.recover', [
            'user' => $this->user
        ], true);
    }
}