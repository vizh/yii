<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 26.06.2015
 * Time: 13:19
 */

namespace pay\components\systems;

use pay\components\CodeException;
use pay\models\Order;

class CloudPayments extends Base
{
    const PUBLIC_ID = 'pk_4f7f741db6b2dd45a2d66421d5c47';
    const API_SECRET = '6a067335dc0204477ceb4159be2817f3';

    /**
     * @return array
     */
    public function getRequiredParams()
    {
    }

    /**
     * @param $orderId
     */
    protected function initRequiredParams($orderId)
    {
    }

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
        $status = $request->getParam('Status', false);
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
        $this->total = (int)$amount;
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
        $request = \Yii::app()->getRequest();
        header('Access-Control-Allow-Origin: '.implode(' ', [
                $request->getSchema().'pay.'.RUNETID_HOST
            ]));

        $order = Order::model()->findByPk($orderId);
        $data = [
            'publicId' => self::PUBLIC_ID,
            'description' => \Yii::t('app', 'Оплата заказа в runet-id.com'),
            'amount' => $total,
            'currency' => 'RUB',
            'invoiceId' => $orderId
        ];
        if ($order->Payer->Visible) {
            $data['email'] = $order->Payer->Email;
        }
        echo json_encode($data);
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
            'Authorization: Basic '.base64_encode(self::PUBLIC_ID.':'.self::API_SECRET)
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
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