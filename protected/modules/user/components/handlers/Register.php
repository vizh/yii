<?php
namespace user\components\handlers;

use mail\components\Mailer;
use mail\components\MailLayout;
use user\models\User;

class Register extends MailLayout
{
    /** @var User */
    private $user;

    /** @var string */
    private $password;

    public function __construct(Mailer $mailer, \CEvent $event)
    {
        parent::__construct($mailer);
        $this->user = $event->sender;
        $this->password = $event->params['password'];
    }


    /**
     * @return string
     */
    public function getSubject()
    {
        return \Yii::t('app', 'Регистрация на сайте www.runet-id.com');
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return 'reg@runet-id.com';
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
        return $this->renderBody((!$this->user->Temporary ? 'user.views.mail.register' : 'user.views.mail.register-temporary'), [
            'user' => $this->user,
            'password' => $this->password
        ]);
    }

    function getUser()
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
    public function showFooter()
    {
        if ($this->user->Temporary) {
            return false;
        }
        return true;
    }


}