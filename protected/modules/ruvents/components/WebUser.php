<?php
namespace ruvents\components;

use \ruvents\models\AccountRole;

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
            self::$instance->initAccount();
        }

        return self::$instance;
    }

    private $account = null;

    private function initAccount()
    {
        $hash = \Yii::app()->getRequest()->getParam('Hash');
        $this->account = \ruvents\models\Account::model()->byHash($hash)->find();
    }

    /**
     * @return \ruvents\models\Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    private $operator = null;
    private $alreadyTryLoad = false;

    /**
     * @throws Exception
     * @return \ruvents\models\Operator
     */
    public function getOperator()
    {
        if (!$this->alreadyTryLoad && $this->operator === null && $this->getAccount() !== null)
        {
            $operatorId = \Yii::app()->getRequest()->getParam('OperatorId');
            /** @var \ruvents\models\Operator $operator */
            $operator = \ruvents\models\Operator::model()->findByPk($operatorId);
            if ($operator !== null)
            {
                if ($operator->EventId != $this->getAccount()->EventId)
                    throw new Exception(103);
                $this->operator = $operator;
            }
            $this->alreadyTryLoad = true;
        }

        return $this->operator;
    }

    public function resetOperator()
    {
        $this->operator = null;
        $this->alreadyTryLoad = false;
    }

    /**
     * @return null|string
     */
    public function getRole()
    {
        if ($this->getAccount() === null) {
            return null;
        } elseif ($this->getAccount()->Role !== AccountRole::SERVER) {
            return $this->getAccount()->Role;
        }
        return $this->getOperator() !== null ? $this->getOperator()->Role : AccountRole::SERVER;
    }

    protected $_access = array();

    public function checkAccess($operation,$params=array(),$allowCaching=true)
    {
        if($allowCaching && $params===array() && isset($this->_access[$operation]))
            return $this->_access[$operation];
        else
            return $this->_access[$operation]= \Yii::app()->ruventsAuthManager->checkAccess($operation,$this->getId(),$params);
    }

    public function getIsGuest()
    {
        return $this->getAccount() === null;
    }

    public function getId()
    {
        if ($this->getAccount() === null)
            return null;
        return $this->getOperator() !== null ? $this->getOperator()->Id : 'acc'.$this->getAccount()->Id;
    }
}