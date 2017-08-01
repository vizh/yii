<?php
namespace pay\components\systems;

use event\models\Event;
use pay\components\CodeException;

abstract class Base
{
    protected $addition;

    public function __construct($addition = null)
    {
        $this->addition = $addition;
    }

    /**
     * @abstract
     * @return array
     */
    abstract public function getRequiredParams();

    abstract protected function initRequiredParams($orderId);

    protected $orderId;

    public function getOrderId()
    {
        return $this->orderId;
    }

    protected $total;

    public function getTotal()
    {
        return $this->total;
    }

    abstract protected function getClass();

    /**
     * Проверяет, может ли данный объект обработать callback платежной системы
     * @abstract
     * @return bool
     */
    abstract public function check();

    /**
     * Заполняет общие параметры всех платежных систем, для единой обработки платежей
     * @abstract
     * @return void
     */
    abstract public function fillParams();

    /**
     * Выполняет отправку пользователя на оплату в соответствующую платежную систему
     * @abstract
     * @param int $eventId
     * @param string $orderId
     * @param int $total
     * @return void
     */
    abstract public function processPayment($eventId, $orderId, $total);

    /**
     * Возвращает строку для логирования callback'а платежной системы
     * @return string
     */
    public function info()
    {
        $result = $_REQUEST;
        $result['System'] = $this->getClass();
        ob_start();
        print_r($result);
        $result = ob_get_clean();
        return $result;
    }

    /**
     * Производит запись в БД после получения Callback, заполняет лог
     * @throws \pay\components\Exception
     * @return void
     */
    public final function parseSystem()
    {
        /** @var $order \pay\models\Order */
        $order = \pay\models\Order::model()->findByPk($this->getOrderId());

        if ($order === null) {
            throw new CodeException(201, [$this->getOrderId()]);
        }

        if ($order->Paid) {
            throw new CodeException(204, [$order->Id]);
        }

        $payResult = $order->activate();

        if ($this->getTotal() !== null) {
            $order->Total = $this->getTotal();
            $order->save();
        }

        if ($this->getTotal() !== null && $payResult['Total'] != $this->getTotal()) {
            throw new CodeException(202);
        }

        if ($this->getTotal() === null) {
            $this->total = $payResult['Total'];
        }

        if (!empty($payResult['ErrorItems'])) {
            $itemList = serialize($payResult['ErrorItems']);
            throw new CodeException(203, [$itemList]);
        }
    }

    /**
     * @abstract
     * @return void
     */
    abstract public function endParseSystem();

    /**
     * Возвращает url обрабатывающий каллбек оплаты заказа
     * @param int $id Id мероприятия
     * @param int $orderId Id заказа
     * @return string
     */
    protected function getReturnUrl($id, $orderId)
    {
        $event = Event::model()->findByPk($id);
        return \Yii::app()->createAbsoluteUrl('/pay/cabinet/return', ['eventIdName' => $event->IdName, 'orderId' => $orderId]);
    }

}