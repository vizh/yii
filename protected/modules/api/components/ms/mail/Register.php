<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 18.11.2015
 * Time: 18:56
 */

namespace api\components\ms\mail;

use mail\components\Mailer;
use user\models\User;

class Register extends Base
{
    /**
     * @var string
     */
    private $password;

    /**
     * @param Mailer $mailer
     * @param User $user
     * @param string|null $password
     */
    public function __construct(Mailer $mailer, User $user, $password = null)
    {
        parent::__construct($mailer, $user);
        $this->password = $password;
    }

    /**
     * @inheritdoc
     */
    public function getBody()
    {
        return $this->renderBody('event.views.mail.register.devcon16.devcon16-register', [
            'user' => $this->user,
            'password' => $this->password
        ]);
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return 'Благодарим Вас за интерес к конференции DevCon 2016!';
    }
}