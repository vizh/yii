<?php
namespace pay\components\systems;

use pay\components\CodeException;

class WalletOne extends Base
{
    private $secretKey;
    private $merchantId;

    /**
     * @return array
     */
    public function getRequiredParams()
    {
        return ['SecretKey', 'MerchantId'];
    }

    /**
     * @param $orderId
     */
    protected function initRequiredParams($orderId)
    {
        $this->secretKey = '765c4e6b64434f5b6454444d686b315b716b62765f454b4d564b33';
        $this->merchantId = '140549145718';
    }

    /**
     * @return string
     */
    protected function getClass()
    {
        return __CLASS__;
    }

    /**
     * Проверяет, может ли данный объект обработать callback платежной системы
     * @return bool
     */
    public function check()
    {
        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        $state = $request->getParam('WMI_ORDER_STATE', false);
        $order = $request->getParam('WMI_PAYMENT_NO', false);
        $amount = $request->getParam('WMI_PAYMENT_AMOUNT', false);
        return $state !== false && $order !== false && $amount !== false;
    }

    /**
     * Заполняет общие параметры всех платежных систем, для единой обработки платежей
     * @throws CodeException
     */
    public function fillParams()
    {
        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();

        $state = $request->getParam('WMI_ORDER_STATE');
        $amount = $request->getParam('WMI_PAYMENT_AMOUNT');

        if ($state != 'Accepted') {
            throw new CodeException(903, [$state]);
        }
        $this->orderId = $request->getParam('WMI_PAYMENT_NO');
        $this->total = intval($amount);
    }

    /**
     * Выполняет отправку пользователя на оплату в соответствующую платежную систему
     * @param int $eventId
     * @param string $orderId
     * @param int $total
     * @return void
     */
    public function processPayment($eventId, $orderId, $total)
    {
        $this->initRequiredParams($orderId);
        $params = [
            'WMI_MERCHANT_ID' => $this->merchantId,
            'WMI_PAYMENT_AMOUNT' => number_format($total, 2, '.', ''),
            'WMI_CURRENCY_ID' => 643, // Валюта росскийский рубль,
            'WMI_DESCRIPTION' => 'BASE64:'.base64_encode(\Yii::t('app', 'Оплата заказа в runet-id.com')),
            'WMI_SUCCESS_URL' => $this->getReturnUrl($eventId),
            'WMI_PAYMENT_NO' => $orderId,
            'WMI_CULTURE_ID' => 'ru-RU'

        ];
        $params['WMI_FAIL_URL'] = $params['WMI_SUCCESS_URL'];
        $params['WMI_SIGNATURE'] = $this->calcSignature($params);

        \Yii::app()->getRequest()->enableCsrfValidation = false;
        $form = \CHtml::tag('h3', ['class' => 'text-center m-top_40 m-bottom_40'], \Yii::t('app', 'Пожалуйста, подождите, идет перенаправление на WalletOne для выполнения платежа.'))
            .\CHtml::form('https://wl.walletone.com/checkout/checkout/Index', 'POST', ['style' => 'display: none;', 'id' => 'walletone']);
        foreach ($params as $name => $value) {
            $form .= \CHtml::hiddenField($name, $value);
        }
        $form .= \CHtml::submitButton();
        $form .= \CHtml::endForm();

        \Yii::app()->getClientScript()->registerScript('walletone', '
            $("form#walletone").submit();
        ', \CClientScript::POS_READY);
        \Yii::app()->getController()->renderText($form);
    }

    /**
     * Подпись формируется путем объединения значений всех остальных параметров формы в алфавитном порядке их имен
     * (без учета регистра) с добавлением в конец «секретного ключа» интернет-магазина. Если форма содержит несколько
     * полей с одинаковыми именами, такие поля сортируются в алфавитном порядке их значений. Полученное после
     * объединения параметров и «секретного ключа» значение, представленное в кодировке Windows-1251, хешируется
     * выбранным методом формирования ЭЦП и его байтовое представление кодируется в Base64.
     * Прототип кода взят со страницы документации http://www.walletone.com/ru/merchant/documentation/
     * @param array $params Параметры запроса
     * @return string
     */
    private function calcSignature(array $params)
    {
        foreach ($params as $name => $val) {
            if (is_array($val)) {
                usort($val, "strcasecmp");
                $params[$name] = $val;
            }
        }

        uksort($params, "strcasecmp");
        $values = "";
        foreach ($params as $value) {
            if (is_array($value)) {
                foreach ($value as $v) {
                    $v = iconv("utf-8", "windows-1251", $v);
                    $values .= $v;
                }
            } else {
                $value = iconv("utf-8", "windows-1251", $value);
                $values .= $value;
            }
        }
        return base64_encode(pack('H*', md5($values.$this->secretKey)));
    }

    /**
     * @return void
     */
    public function endParseSystem()
    {
        echo 'WMI_RESULT=OK';
        exit;
    }

    /**
     * @return string
     */
    public function info()
    {
        unset($_REQUEST['WMI_DESCRIPTION']);
        return parent::info();
    }
}