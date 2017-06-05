<?php
namespace partner\components;

class Identity extends \CUserIdentity
{
    private $_id;

    public function authenticate()
    {
        /** @var $account \partner\models\Account */
        $account = \partner\models\Account::model()->find('"t"."Login" = :Login', [':Login' => $this->username]);

        if ($account === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } elseif (!$account->checkLogin($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id = $account->Id;
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId()
    {
        return $this->_id;
    }
}
