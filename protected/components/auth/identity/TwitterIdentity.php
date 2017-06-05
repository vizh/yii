<?php

/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 22.06.11
 * Time: 11:58
 * To change this template use File | Settings | File Templates.
 */
class TwitterIdentity extends GeneralIdentity
{
    private $_id;

    /**
     * @var string email
     */
    public $twitterHash;

    public function __construct($twitterHash)
    {
        $this->twitterHash = $twitterHash;
    }

    public function authenticate()
    {
        $connectTwitter = UserConnect::GetByHash($this->twitterHash, UserConnect::TwitterId);
        $user = null;
        if ($connectTwitter != null) {
            $user = User::GetById($connectTwitter->UserId);
        }

        if ($user === null || $user->Settings->Visible == 0) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            $this->_id = $user->UserId;
            $this->errorCode = self::ERROR_NONE;
            $user->CreateSecretKey();
        }
        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId()
    {
        return $this->_id;
    }
}
