<?php
namespace pay\components\systems;

use CHttpException;
use event\models\Event;
use pay\components\CodeException;
use pay\models\Order;
use Yii;

class PayOnline extends Base
{
    const PAYMENT_BASE_URL_FORMAT = 'https://secure.payonlinesystem.com/%s/payment/select/';
    const CURRENCY_CODE = 'RUB';

    private $merchantId;
    private $privateSecurityKey;

    public $toYandexMoney = false;
    public $SaveRebill = false;


    /**
     * @return array
     */
    public function getRequiredParams()
    {
        return array('MerchantId', 'PrivateSecurityKey');
    }

    protected function initRequiredParams($orderId)
    {
        if ($this->addition === 'ruvents') {
            $this->merchantId = 74160;
            $this->privateSecurityKey = 'dd9cdbeb-70c5-4371-9aab-be0918c5ba5e';
        } else {
            $this->merchantId = 52855;
            $this->privateSecurityKey = 'f7726060-0172-4995-a042-5f18fde2581d';
        }
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
        $request = Yii::app()->getRequest();

        return $request->getParam('Amount') !== null
            && $request->getParam('Provider') !== null;
    }

    /**
     * Заполняет общие параметры всех платежных систем, для единой обработки платежей
     * @throws \pay\components\Exception
     * @return void
     */
    public function FillParams()
    {
        $request = Yii::app()->getRequest();
        $orderId = $request->getParam('OrderId');

        $this->initRequiredParams($orderId);

        $query = urldecode(http_build_query([
            'DateTime' => $request->getParam('DateTime'),
            'TransactionID' => $request->getParam('TransactionID'),
            'OrderId' => $request->getParam('OrderId'),
            'Amount' => $request->getParam('Amount'),
            'Currency' => $request->getParam('Currency'),
            'PrivateSecurityKey' => $this->privateSecurityKey
        ]));

        if ($request->getParam('SecurityKey') === md5($query)) {
            $this->orderId = $orderId;
            $this->total = (int)$request->getParam('Amount');
        } else {
            throw new CodeException(901);
        }
    }

    /**
     * Выполняет отправку пользователя на оплату в соответствующую платежную систему
     *
     * @param int $eventId
     * @param string $orderId
     * @param int $total
     * @return void
     * @throws \CHttpException
     */
    public function processPayment($eventId, $orderId, $total)
    {
        $this->initRequiredParams($orderId);

        $params = [
            'MerchantId' => $this->merchantId,
            'OrderId' => $orderId,
            'Amount' => number_format($total, 2, '.', ''),
            'Currency' => self::CURRENCY_CODE,
            'PrivateSecurityKey' => $this->privateSecurityKey
        ];

        $hash = md5(http_build_query($params));
        unset($params['PrivateSecurityKey']);

        $event = Event::model()->findByPk($eventId);
        $order = Order::model()->findByPk($orderId);

        if ($order === null)
            throw new CHttpException(404);

        if ($this->SaveRebill && $order->Payer->PayonlineRebill == null){
            $order->Payer->updateByPk($order->Payer->Id, ['PayonlineRebill' => 'pending']);
        }
        $params = array_merge($params, [
            'Email' => $order->Payer->Email,
            'SecurityKey' => $hash
        ]);

        Yii::app()->getController()->redirect(sprintf('%s%s?%s',
            sprintf(self::PAYMENT_BASE_URL_FORMAT, Yii::app()->getLanguage()),
            $this->toYandexMoney ? 'yandexmoney/' : '',
            http_build_query($params)
        ));
    }

    /**
     * @return void
     */
    public function EndParseSystem()
    {
        /** @var $order \pay\models\Order */
        $order = \pay\models\Order::model()->findByPk($this->getOrderId());
        if ($order->Payer->PayonlineRebill == 'pending'){
            $order->Payer->PayonlineRebill = Yii::app()->request->getParam('RebillAnchor');
            $order->Payer->save(false);
        }

        header('Status: 200');
        echo '<script type="text/javascript">window.top.location.href = "'.$this->getReturnUrl($order->EventId).'";</script>';
        exit();
    }
}
