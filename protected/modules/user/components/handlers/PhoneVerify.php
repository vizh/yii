<?php
namespace user\components\handlers;


use sms\components\Gate;
use sms\components\Message;
use user\models\User;

class PhoneVerify extends Message
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
        return \Yii::t('app', 'RUNET-ID. Ваш код подтверждения: {code}', ['{code}' => $this->user->getPrimaryPhoneVerifyCode()]);
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->user->PrimaryPhone;
    }
}