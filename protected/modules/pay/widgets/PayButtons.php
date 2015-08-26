<?php
namespace pay\widgets;

use application\components\web\Widget;
use pay\models\Account;

class PayButtons extends Widget
{
    /** @var Account */
    public $account;

    public $htmlOptions = [];

    public static $PaySystems  = ['uniteller', 'payonline', 'yandexmoney', 'paypal', 'cloudpayments'];
    public static $OnlineMoney = ['yandexmoney', 'paypal'];

    /**
     *
     */
    public function init()
    {
        $this->registerResources();
    }

    /**
     * @throws \CException
     */
    public function run()
    {
        $this->render('pay-buttons');
    }

    /**
     * Список кнопок для оплаты через электронные деньги
     * @return string[]
     */
    public function getPayButtons()
    {
        $buttons = [];
        if ($this->account->PayOnline) {
            $buttons[] = 'yandexmoney';
        }
        $buttons[] = 'paypal';
        if ($this->account->MailRuMoney) {
            $buttons[] = 'mailrumoney';
        }
        return $buttons;
    }

    /**
     * Список кнопок для оплаты через платежные системы
     * @return string[]
     */
    public function getSytemButtons()
    {
        $buttons = [];
        if ($this->account->Uniteller) {
            $buttons[] = 'uniteller';
        }
        if ($this->account->PayOnline) {
            $buttons[] = 'payonline';
        }
        if ($this->account->CloudPayments) {
            $buttons[] = 'cloudpayments';
        }
        return $buttons;
    }

    /**
     * @param string $name
     * @param string $system
     */
    public function renderButton($name, $system = null)
    {
        if ($system === null) {
            $system = $name;
        }
        $this->render('buttons/' . $name, ['account' => $this->account, 'system' => $system]);
    }

    /**
     * @param $name
     * @return array
     */
    public function getHtmlOptions($name)
    {
        $options = $this->htmlOptions;
        $options['class'] .= ' '.$name;
        return $options;
    }

    /**
     * @inheritdoc
     */
    public function getIsHasDefaultResources()
    {
        return true;
    }


}