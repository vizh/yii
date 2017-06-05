<?php
namespace ruvents2\components;

use ruvents2\models\Account;
use ruvents2\models\Operator;

class WebUser extends \CWebUser
{
    public $loginUrl = null;

    private static $instance = null;

    /**
     * @static
     * @return WebUser
     */
    public static function Instance()
    {
        if (self::$instance === null) {
            self::$instance = new WebUser();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->init();
    }

    public function init()
    {
        // Не вызываем родительский init(), так как он рассчитан на авторизацию на основе сессий
        $headers = getallheaders();
        $hash = isset($headers['X-Ruvents-Hash']) ? $headers['X-Ruvents-Hash'] : null;
        $operatorId = isset($headers['X-Ruvents-Operator']) ? $headers['X-Ruvents-Operator'] : null;
        if ($hash !== null) {
            $this->account = Account::model()->byHash($hash)->find();
            if ($this->account === null) {
                throw new Exception(Exception::INVALID_HASH);
            }
        }
        if ($operatorId !== null && $this->account !== null) {
            $this->operator = Operator::model()->findByPk($operatorId);
            if ($this->operator === null) {
                throw new Exception(Exception::INVALID_OPERATOR_ID, $operatorId);
            }
            if ($this->operator->EventId !== $this->account->EventId) {
                throw new Exception(Exception::INVALID_OPERATOR_EVENT, $this->operator->Id);
            }
        }
    }

    private $account = null;

    /**
     * @return Account|null
     */
    public function getAccount()
    {
        return $this->account;
    }

    private $operator = null;

    /**
     * @return Operator|null
     */
    public function getOperator()
    {
        return $this->operator;
    }

    public function getRole()
    {
        if ($this->getOperator() !== null) {
            return Role::OPERATOR;
        } elseif ($this->getAccount() !== null) {
            return Role::SERVER;
        }
        return Role::GUEST;
    }

    public function getIsGuest()
    {
        return $this->getAccount() === null;
    }

    public function getId()
    {
        if ($this->getAccount() === null) {
            return null;
        }
        return $this->getOperator() !== null ? $this->getOperator()->Id : 'account_'.$this->getAccount()->Id;
    }
}

if (!function_exists('getallheaders')) {
    function getallheaders()
    {
        $headers = '';
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}