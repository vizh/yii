<?php

class PayOnlineSystem extends BaseSystem
{
  const Url = 'https://secure.payonlinesystem.com/ru/payment/select/';
  //const PrivateSecurityKey = '8cce489d-57d6-41ea-bf3f-c9b6c35db540';
  //const MerchantId = 2452;
  const Currency = 'RUB';

  private $merchantId;
  private $privateSecurityKey;

  /**
   * @return array
   */
  public function RequiredParams()
  {
    return array('MerchantId', 'PrivateSecurityKey');
  }

  protected function initRequiredParams($orderId)
  {
    $params = null;
    $order = Order::GetById($orderId);
    if (!empty($order))
    {
      $account = PayAccount::GetByEventId($order->EventId);
      $params = !empty($account) ? $account->GetSystemParams() : null;
    }

    if (!empty($params))
    {
      $this->merchantId = $params['MerchantId'];
      $this->privateSecurityKey = $params['PrivateSecurityKey'];
    }
    else
    {
      $this->merchantId = 2452;
      $this->privateSecurityKey = '8cce489d-57d6-41ea-bf3f-c9b6c35db540';
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
  public function Check()
  {
    $amount = Registry::GetRequestVar('Amount', false);
    $provider = Registry::GetRequestVar('Provider', false);
    return $amount !== false && $provider !== false;
  }

  /**
   * Заполняет общие параметры всех платежных систем, для единой обработки платежей
   * @return void
   */
  public function FillParams()
  {
    $orderId = Registry::GetRequestVar('OrderId');
    $this->initRequiredParams($orderId);
    $params = array();
    $params['DateTime'] = Registry::GetRequestVar('DateTime');
    $params['TransactionID'] = Registry::GetRequestVar('TransactionID');
    $params['OrderId'] = Registry::GetRequestVar('OrderId');
    $params['Amount'] = Registry::GetRequestVar('Amount');
    $params['Currency'] = Registry::GetRequestVar('Currency');
    $params['PrivateSecurityKey'] = $this->privateSecurityKey;

    $query = urldecode(http_build_query($params));

    $hash = md5($query);
    if ($hash === Registry::GetRequestVar('SecurityKey'))
    {
      $this->OrderId = $orderId;
      $this->Total = intval(Registry::GetRequestVar('Amount'));
    }
    else
    {
      throw new PayException('Ошибка при вычислении хеша!', 211);
    }
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
    $this->initRequiredParams($orderId);
    $total = number_format($total, 2, '.', '');

    $params = array();
    $params['MerchantId'] = $this->merchantId;
    $params['OrderId'] = $orderId;
    $params['Amount'] = $total;
    $params['Currency'] = self::Currency;
    $params['PrivateSecurityKey'] = $this->privateSecurityKey;

    $hash = md5(http_build_query($params));
    unset($params['PrivateSecurityKey']);

    $params['SecurityKey'] = $hash;
    $params['ReturnUrl'] = RouteRegistry::GetUrl('main', '', 'return', array('eventId' => $eventId));

    Lib::Redirect(self::Url . '?' . http_build_query($params));
  }

  /**
   * @return void
   */
  public function EndParseSystem()
  {
    header('Status: 200');
    echo 'OK';
    exit();
  }
}
