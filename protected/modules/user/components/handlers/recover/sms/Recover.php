<?php
namespace user\components\handlers\recover\sms;

use sms\components\Gate;
use sms\components\Message;
use user\models\User;

class Recover extends Message
{
    private $user;

    /**
     * @param Gate $gate
     * @param User $user
     */
    public function __construct(Gate $gate, User $user)
    {
        $this->user = $user;
        parent::__construct($gate);
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return 'Для сброса пароля RUNET-ID введите код: '.$this->user->getRecoveryHash();
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->user->PrimaryPhone;
    }
}