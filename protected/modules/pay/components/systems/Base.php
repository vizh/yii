<?php
namespace pay\components\systems;

abstract class Base
{
    protected  $addition = null;

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

    if (empty($order))
    {
      throw new \pay\components\Exception('Оплачен неизвестный заказ номер ' . $this->getOrderId(), 201);
    }

    if ($order->Paid)
    {
      throw new \pay\components\Exception('Заказ номер ' . $order->Id . 'уже оплачен', 204);
    }

    $payResult = $order->activate();

    if ($this->getTotal() !== null)
    {
      $order->Total = $this->getTotal();
      $order->save();
    }

    if ($this->getTotal() !== null && $payResult['Total'] != $this->getTotal())
    {
      throw new \pay\components\Exception('Сумма заказа и полученная через платежную систему не совпадают', 202);
    }

    if ($this->getTotal() === null)
    {
      $this->total = $payResult['Total'];
    }

    if (!empty($payResult['ErrorItems']))
    {
      $itemList = serialize($payResult['ErrorItems']);
      throw new \pay\components\Exception('Один или несколько товаров имеют более ценный эквивалент среди уже приобретенных пользователем. Список id:' . $itemList, 203);
    }
  }

  /**
   * @abstract
   * @return void
   */
  abstract public function endParseSystem();

}