<?php
namespace api\components;

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
    private $alreadyTryLoad = false;

    /**
     * @return \api\models\Account
     */
    public function getAccount()
    {
        if ($this->account === null && !$this->alreadyTryLoad)
        {
            $request = \Yii::app()->getRequest();
            $apiKey = $request->getParam('ApiKey');
            $hash = $request->getParam('Hash');
            $timestamp = $request->getParam('Timestamp');
            $ip = $_SERVER['REMOTE_ADDR'];

            /** @var $account \api\models\Account */
            $account = \api\models\Account::model()->byKey($apiKey)->find();

            if ($account !== null && $account->checkHash($hash, $timestamp) &&
                ($account->EventId == null || $account->checkIp($ip)))
            {
                $this->account = $account;
                if ($this->account->EventId === null)
                {
                    $this->account->EventId = \Yii::app()->getRequest()->getParam('EventId', null);
                }
            }

            $this->alreadyTryLoad = true;
        }

        return $this->account;
    }

    public function resetAccount()
    {
        $this->account = null;
        $this->alreadyTryLoad = false;
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