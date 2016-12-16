<?php
namespace application\components\auth\identity;

use user\models\User;

class Password extends \application\components\auth\identity\Base
{
    public function __construct($login, $password)
    {
        $this->username = $login;
        $this->password = $password;
    }

    public function authenticate()
    {
        $user = User::model()
            ->byRunetId($this->username)
            ->byEmail($this->username, false)
            ->byPrimaryPhone($this->username, false)
            ->byVisible()
            ->find();

        if ($user === null) {
            return self::ERROR_USERNAME_INVALID;
        }

        if ($user->checkLogin($this->password) === false) {
            return self::ERROR_PASSWORD_INVALID;
        }

        $this->_id = $user->Id;
        $this->username = $user->RunetId;
        $this->errorCode = self::ERROR_NONE;

        return true;
    }
}
