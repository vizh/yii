<?php

class PayPalSystem extends BaseSystem
{
  const Url = 'https://api-3t.sandbox.paypal.com/nvp';
  const Version = '91.0';


  /**
   * @return array
   */
  public function RequiredParams()
  {
    // TODO: Implement RequiredParams() method.
  }

  protected function initRequiredParams($orderId)
  {
    // TODO: Implement initRequiredParams() method.
  }

  protected function getClass()
  {
    // TODO: Implement getClass() method.
  }

  /**
   * Проверяет, может ли данный объект обработать callback платежной системы
   * @return bool
   */
  public function Check()
  {
    // TODO: Implement Check() method.
  }

  /**
   * Заполняет общие параметры всех платежных систем, для единой обработки платежей
   * @return void
   */
  public function FillParams()
  {
    // TODO: Implement FillParams() method.
  }

  /**
   * Выполняет отправку пользователя на оплату в соответствующую платежную систему
   * @param int $eventId
   * @param string $orderId
   * @param int $total
   * @return void
   */
  public function ProcessPayment($eventId, $orderId, $total)
  {
    // TODO: Implement ProcessPayment() method.
  }

  /**
   * @return void
   */
  public function EndParseSystem()
  {
    // TODO: Implement EndParseSystem() method.
  }
}
