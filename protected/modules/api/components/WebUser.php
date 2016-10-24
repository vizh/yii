<?php
namespace api\components;

use api\models\Account;

class WebUser extends \CWebUser
{
    private static $instance = null;

    /**
     * @static
     * @return WebUser
     */
    public static function Instance()
    {
        if (self::$instance === null)
        {
            self::$instance = new WebUser();
        }

        return self::$instance;
    }

    private $account = null;

    /**
     * @return Account
     * @throws Exception
     */
    public function getAccount()
    {
        if ($this->account === null)
        {
            $request = \Yii::app()->getRequest();

            $key = $request->getParam('ApiKey');
            $hash = $request->getParam('Hash');
            $timestamp = $request->getParam('Timestamp');

            $account = \Yii::app()
                ->getCache()
                ->get("$key,$hash,$timestamp");

            if ($account === false)
            {
                $account = Account::model()
                    ->byKey($key)
                    ->with('Event')
                    ->find();

                if ($account === null)
                    throw new Exception(101);

                if ($account->checkHash($hash, $timestamp) === false)
                    throw new Exception(102);

                // Предоставляем возможность иметь api-аккаунты с динамической привязкой к мероприятию
                if ($account->EventId === null)
                    $account->EventId = $request->getParam('EventId');

                if ($account->checkIp($_SERVER['REMOTE_ADDR']) === false)
                    throw new Exception(103);

                \Yii::app()
                    ->getCache()
                    ->set("$key,$hash,$timestamp", $account, 30);
            }

            $this->account = $account;
        }

        return $this->account;
    }

    public function resetAccount()
    {
        $this->account = null;
    }

    /**
     * @return null|string
     */
    public function getRole()
    {
        if ($this->getAccount() !== null)
        {
            return $this->getAccount()->Role;
        }
        return null;
    }

    protected $_access = array();

    public function checkAccess($operation,$params=array(),$allowCaching=true)
    {
        if($allowCaching && $params===array() && isset($this->_access[$operation]))
            return $this->_access[$operation];
        else
            return $this->_access[$operation]= \Yii::app()->apiAuthManager->checkAccess($operation,$this->getId(),$params);
    }

    public function getIsGuest()
    {
        return $this->getAccount() === null;
    }

    public function getId()
    {
        return !$this->getIsGuest() ? $this->getAccount()->Id : null;
    }

    public function loginRequired()
    {
        try {
            parent::loginRequired();
        } catch (\CHttpException $e) {
            throw new Exception(100, [$e->getMessage()]);
        }
    }
}