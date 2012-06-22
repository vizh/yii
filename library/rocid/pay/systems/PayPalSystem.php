<?php

class PayPalSystem extends BaseSystem
{
  const Url = 'https://api-3t.sandbox.paypal.com/nvp';
  const Version = '91.0';

  private $username;
  private $password;
  private $signature;


  /**
   * @return array
   */
  public function RequiredParams()
  {
    return array('Username', 'Password', 'Signature');
  }

  protected function initRequiredParams($orderId)
  {
    $this->username = 'n_1340289183_biz_api1.internetmediaholding.com';
    $this->password = '1340289210';
    $this->signature = 'ASotwUFhF77eR9f46CC9ZDcSDh5XAL4B5T88RqduJwvavxHmvkhlZSvG';
  }

  protected function getClass()
  {
    return __CLASS__;
  }

  /**
   * Проверяет, может ли данный объект обработать callback платежной системы
   * @return bool
   */
  public function Check()
  {
    // TODO: Implement Check() method.
    return false;
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
