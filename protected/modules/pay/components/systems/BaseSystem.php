<?php
namespace pay\models\systems;

abstract class BaseSystem
{
    /**
     * @abstract
     * @return array
     */
    abstract public function RequiredParams();

    abstract protected function initRequiredParams($orderId);

    protected $OrderId;

    public function OrderId()
    {
        return $this->OrderId;
    }

    protected $Total;

    public function Total()
    {
        return $this->Total;
    }

    abstract protected function getClass();

    /**
     * Проверяет, может ли данный объект обработать callback платежной системы
     * @abstract
     * @return bool
     */
    abstract public function Check();

    /**
     * Заполняет общие параметры всех платежных систем, для единой обработки платежей
     * @abstract
     * @return void
     */
    abstract public function FillParams();

    /**
     * Выполняет отправку пользователя на оплату в соответствующую платежную систему
     * @abstract
     * @param int $eventId
     * @param string $orderId
     * @param int $total
     * @return void
     */
    abstract public function ProcessPayment($eventId, $orderId, $total);

    /**
     * Возвращает строку для логирования callback'а платежной системы
     * @return string
     */
    public function Info()
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
     * @throws \pay\models\PayException
     * @return void
     */
    public final function ParseSystem()
    {
        $order = \pay\models\Order::GetById($this->OrderId());

        if (empty($order)) {
            throw new \pay\models\PayException('Оплачен неизвестный заказ номер '.$this->OrderId(), 201);
        }

        $payResult = $order->PayOrder();

        if ($payResult['Total'] != $this->Total()) {
            throw new \pay\models\PayException('Сумма заказа и полученная через платежную систему не совпадают', 202);
        }

        if (!empty($payResult['ErrorItems'])) {
            $itemList = serialize($payResult['ErrorItems']);
            throw new \pay\models\PayException('Один или несколько товаров имеют более ценный эквивалент среди уже приобретенных пользователем. Список id:'.$itemList, 203);
        }
    }

    /**
     * @abstract
     * @return void
     */
    abstract public function EndParseSystem();

}