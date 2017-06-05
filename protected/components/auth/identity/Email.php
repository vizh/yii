<?php
namespace application\components\auth\identity;

class Email extends \application\components\auth\identity\Base
{
    /**
     * @var string
     */
    public $email;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function authenticate()
    {
        $user = User::GetByEmail($this->email);

        if ($user === null || $user->Settings->Visible == 0) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } elseif (!$user->CheckLogin($user->RocId, $this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id = $user->UserId;
            $this->errorCode = self::ERROR_NONE;
            $user->CreateSecretKey();
        }
        return $this->errorCode == self::ERROR_NONE;
    }
}
