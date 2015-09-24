<?php
namespace pay\components\systems;

use pay\components\CodeException;

class WalletOne extends Base
{
    const SECRET_KEY = '32415e7b5e6650685035705e336a3254696335306f5c6d6a696948';
    const WMI_MERCHANT_ID  = '129482046877';
    const WMI_CURRENCY_ID  = 643;

    /**
     * @return array
     */
    public function getRequiredParams() {}

    /**
     * @param $orderId
     */
    protected function initRequiredParams($orderId) {}

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
        $invoiceId = $request->getParam('InvoiceId', false);
        $status  = $request->getParam('Status', false);
        $amount = $request->getParam('Amount');
        return $invoiceId !== false && $status !== false && $amount !== false;
    }

    /**
     * Заполняет общие параметры всех платежных систем, для единой обработки платежей
     * @throws CodeException
     */
    public function fillParams()
    {
        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();

        $invoiceId = $request->getParam('InvoiceId');
        $status = $request->getParam('Status');
        $amount = $request->getParam('Amount');
        if ($status != 'Completed') {
            throw new CodeException(903, [$status]);
        } elseif (!$this->checkInvoice($invoiceId)) {
            throw new CodeException(901);
        }

        $this->orderId = $invoiceId;
        $this->total = (int) $amount;
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
        $params = [
            'WMI_MERCHANT_ID' => self::WMI_MERCHANT_ID,
            'WMI_PAYMENT_AMOUNT' => number_format($total, 2, '.', ''),
            'WMI_CURRENCY_ID' => self::WMI_CURRENCY_ID,
            'WMI_DESCRIPTION' => 'BASE64:' . base64_encode(\Yii::t('app', 'Оплата заказа в runet-id.com')),
            'WMI_SUCCESS_URL' => $this->getReturnUrl($eventId),
            'WMI_PAYMENT_NO'  => $orderId,
            'WMI_CULTURE_ID'  => 'ru-RU'

        ];
        $params['WMI_FAIL_URL'] = $params['WMI_SUCCESS_URL'];
        $params['WMI_SIGNATURE'] = $this->calcSignature($params);

        $form = \CHtml::tag('h3', ['class' => 'text-center m-top_40 m-bottom_40'], \Yii::t('app', 'Пожалуйста, подождите, идет перенаправление на WalletOne для выполнения платежа.'))
            . \CHtml::form('https://www.walletone.com/checkout/default.aspx', 'POST', ['style' => 'display: none;','id' => 'walletone']);
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
                usort($val, 'strcasecmp');
                $params[$name] = $val;
            }
        }

        uksort($params, 'strcasecmp');
        $values = '';
        foreach ($params as $value) {
            if (is_array($value)) {
                foreach ($value as $v) {
                    $values .= $v;
                }
            } else {
                $values .= $value;
            }
        }
        return base64_encode(pack('H*', md5($values . self::SECRET_KEY)));
    }

    /**
     * @return void
     */
    public function endParseSystem()
    {
        echo json_encode(['code' => 0]);
        exit;
    }


    /**
     * @param $id
     * @return bool
     */
    private function checkInvoice($id)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.cloudpayments.ru/payments/find');
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . base64_encode(self::PUBLIC_ID . ':' . self::API_SECRET)
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, ['InvoiceId' => $id]);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = json_decode(curl_exec($curl));
        if (isset($result->Model) && $result->Model->Status == 'Completed') {
            return true;
        }
        return false;
    }
}