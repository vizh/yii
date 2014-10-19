<?php
use pay\components\CodeException;

class PayController extends \widget\components\Controller
{
    protected function getWidgetParamNames()
    {
        return ['products'];
    }

    public function getWidgetParamValue($name)
    {
        $value = parent::getWidgetParamValue($name);
        if ($name == 'products' && $value !== null) {
            $value = explode(',', $value);
        }
        return $value;
    }


    public function actions()
    {
        return [
            'index' => '\widget\controllers\pay\IndexAction',
            'auth' => '\widget\controllers\pay\AuthAction',
            'register' => '\widget\controllers\pay\RegisterAction',
            'cabinet' => '\widget\controllers\pay\CabinetAction',
            'juridical' => '\widget\controllers\pay\JuridicalAction',
            'receipt' => '\widget\controllers\pay\ReceiptAction'
        ];
    }

    protected function getStepActionMap()
    {
        return [
            'index',
            'auth',
            'register',
            'cabinet'
        ];
    }

    /**
     * @return string
     * @throws CHttpException
     */
    public function getNextStepUrl()
    {
        $step = array_search($this->getAction()->getId(), $this->getStepActionMap());
        if ($step === false || sizeof($this->getStepActionMap()) == ($step+1))
            throw new \CHttpException(404);

        $action = $this->getStepActionMap()[$step+1];
        return $this->createUrl('/widget/pay/'.$action);
    }

    /*
     *
     */
    public function gotoNextStep()
    {
        $this->redirect($this->getNextStepUrl());
    }

    /**
     * @return \user\models\User
     */
    public function getUser()
    {
        if (\Yii::app()->user->getCurrentUser() !== null)
        {
            return \Yii::app()->user->getCurrentUser();
        }
        elseif (\Yii::app()->payUser->getCurrentUser() !== null)
        {
            return \Yii::app()->payUser->getCurrentUser();
        }
        return null;
    }

    protected $account = null;

    /**
     * @return \pay\models\Account
     * @throws Exception
     */
    public function getAccount()
    {
        $this->account = \pay\models\Account::model()->byEventId($this->getEvent()->Id)->find();
        if ($this->account === null)
        {
            throw new CodeException(CodeException::NO_PAY_ACCOUNT, [$this->getEvent()->Id, $this->getEvent()->IdName, $this->getEvent()->Title]);
        }
        return $this->account;
    }
} 