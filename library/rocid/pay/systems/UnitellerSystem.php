<?php


class UnitellerSystem extends BaseSystem
{
  const Url = 'https://wpay.uniteller.ru/pay/';


  private $shopId;
  private $password;

  /**
   * @return array
   */
  public function RequiredParams()
  {
    return array('Shop_IDP', 'Password');
  }

  protected function initRequiredParams($orderId)
  {
    $this->shopId = '00000524';
    $this->password = 'Ip4Ft2bcCCGezOni6S9aihhAZ2I0MPlUJgw9G1SNflmZMkJ7UIIQVheXtZG29cGUsSSxko9stQWHXdqK';
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
    $orderId = Registry::GetRequestVar('Order_ID', false);
    $signature = Registry::GetRequestVar('Signature', false);
    return $orderId !== false && $signature !== false;
  }

  /**
   * Заполняет общие параметры всех платежных систем, для единой обработки платежей
   * @return void
   */
  public function FillParams()
  {
    $orderId = Registry::GetRequestVar('Order_ID');
    $this->initRequiredParams($orderId);
    $status = Registry::GetRequestVar('Status');
    $hash = strtoupper(md5($orderId + $status + $this->password));

    if ($status != 'paid')
    {
      throw new PayException('Не корректный статус платежа: ' . $status .'!', 221);
    }

    if ($hash === Registry::GetRequestVar('Signature'))
    {
      $this->OrderId = $orderId;
      $this->Total = Registry::GetSession()->get('UnitellerTotalRub');
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
    $params['Shop_IDP'] = $this->shopId;
    $params['Order_IDP'] = $orderId;
    $params['Subtotal_P'] = $total;

    $signature = strtoupper(md5(md5($this->shopId) . '&'
      . md5($orderId) . '&'
      . md5($total) . '&'
      . md5('') . '&'
      . md5('') . '&'
      . md5('') . '&'
      . md5('') . '&'
      . md5('') . '&'
      . md5('') . '&'
      . md5('') . '&'
      . md5($this->password)));


    $params['Signature'] = $signature;
    $params['URL_RETURN'] = RouteRegistry::GetUrl('main', '', 'return', array('eventId' => $eventId));

    $view = new View();
    $view->SetLayout('pay');
    $view->UseLayout(true);
    $view->SetTemplate('uniteller', 'core', 'uniteller', '', 'public');

    $view->Url = self::Url . '?' . http_build_query($params);

    echo $view;

    //Lib::Redirect(self::Url . '?' . http_build_query($params));
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
