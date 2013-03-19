<?php
namespace pay\components\systems;

class PayOnline extends Base
{
  const Url = 'https://secure.payonlinesystem.com/ru/payment/select/';
  const Currency = 'RUB';

  private $merchantId;
  private $privateSecurityKey;

  /**
   * @return array
   */
  public function getRequiredParams()
  {
    return array('MerchantId', 'PrivateSecurityKey');
  }

  protected function initRequiredParams($orderId)
  {
    $this->merchantId = 2452;
    $this->privateSecurityKey = '8cce489d-57d6-41ea-bf3f-c9b6c35db540';
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
    $request = \Yii::app()->getRequest();
    $amount = $request->getParam('Amount', false);
    $provider = $request->getParam('Provider', false);
    return $amount !== false && $provider !== false;
  }

  /**
   * Заполняет общие параметры всех платежных систем, для единой обработки платежей
   * @throws \pay\components\Exception
   * @return void
   */
  public function FillParams()
  {
    $request = \Yii::app()->getRequest();
    $orderId = $request->getParam('OrderId');
    $this->initRequiredParams($orderId);
    $params = array();
    $params['DateTime'] = $request->getParam('DateTime');
    $params['TransactionID'] = $request->getParam('TransactionID');
    $params['OrderId'] = $request->getParam('OrderId');
    $params['Amount'] = $request->getParam('Amount');
    $params['Currency'] = $request->getParam('Currency');
    $params['PrivateSecurityKey'] = $this->privateSecurityKey;

    $query = urldecode(http_build_query($params));

    $hash = md5($query);
    if ($hash === $request->getParam('SecurityKey'))
    {
      $this->orderId = $orderId;
      $this->total = intval($request->getParam('Amount'));
    }
    else
    {
      throw new \pay\components\Exception('Ошибка при вычислении хеша!', 211);
    }
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
    $params['ReturnUrl'] = \Yii::app()->createAbsoluteUrl('/pay/cabinet/return', array('eventIdName' => \event\models\Event::model()->findByPk($eventId)->IdName));

    \Yii::app()->getController()->redirect(self::Url . '?' . http_build_query($params));
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
