<?php
namespace application\components\auth\identity;

class FastAuth extends \application\components\auth\identity\Base
{
    public $runetId;

    public function __construct($runetId)
    {
        $this->runetId = $runetId;
    }

    public function authenticate()
    {
        $user = \user\models\User::model()->byRunetId($this->runetId)->find();

        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            $this->_id = $user->Id;
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
    }
}
