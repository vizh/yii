<?php

/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 22.06.11
 * Time: 11:57
 * To change this template use File | Settings | File Templates.
 */
class FacebookIdentity extends GeneralIdentity
{
    private $_id;

    /**
     * @var string
     */
    public $facebookHash;

    public function __construct($facebookHash)
    {
        $this->facebookHash = $facebookHash;
    }

    public function authenticate()
    {
        $connect = UserConnect::GetByHash($this->facebookHash, UserConnect::FacebookId);
        $user = null;
        if ($connect != null) {
            $user = User::GetById($connect->UserId);
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
