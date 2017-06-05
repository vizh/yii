<?php
namespace api\components\ms\mail;

use mail\components\Mailer;
use user\models\User;

class AuthCode extends Base
{
    /** @var string */
    private $code;

    public function __construct(Mailer $mailer, User $user, $code)
    {
        parent::__construct($mailer, $user);
        $this->code = $code;
    }

    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return 'Код подтверждения для входа в личный кабинет DevCon 2016';
    }

    /**
     * @inheritdoc
     */
    public function getBody()
    {
        return $this->renderBody('event.views.mail.register.devcon16.devcon16-authcode', [
            'code' => $this->code,
            'user' => $this->user
        ]);
    }
}