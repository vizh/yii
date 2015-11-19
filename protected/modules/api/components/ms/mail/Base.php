<?php
namespace api\components\ms\mail;

use mail\components\Mailer;
use mail\components\MailLayout;
use mail\models\Layout;
use user\models\User;

abstract class Base extends MailLayout
{
    /** @var User */
    protected $user;

    public function __construct(Mailer $mailer, User $user)
    {
        parent::__construct($mailer);
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getLayoutName()
    {
        return Layout::DevCon16;
    }

    /**
     * @inheritdoc
     */
    public function getFrom()
    {
        return 'devcon@runet-id.com';
    }

    /**
     * @inheritdoc
     */
    public function getFromName()
    {
        return 'DevCon 2016';
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}