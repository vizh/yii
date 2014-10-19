<?php
namespace pay\components\systems;
use pay\components\CodeException;
use pay\components\Exception;

\Yii::import('ext.ExchangeRates.*');

class PayPal extends Base
{
  const Url = 'https://api-3t.paypal.com/nvp';
  const Version = 89.0;

  private $username;
  private $password;
  private $signature;


  /**
   * @return array
   */
  public function getRequiredParams()
  {
    return array('Username', 'Password', 'Signature');
  }

  protected function initRequiredParams($orderId)
  {
    $this->username = 'grebennikov_api1.imcom.co.uk';
    $this->password = 'QKQDST7CGKB4R52D';
    $this->signature = 'A6zZXZ2LRlaG0Cu4I0Zz2k.vlGrCAfR1Cem2U-ZxIZF-.oidUOheR4ei';
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
    $token = $request->getParam('token', false);
    $PayerID = $request->getParam('PayerID', false);
    return $token !== false && $PayerID !== false;
  }

  /**
   * Заполняет общие параметры всех платежных систем, для единой обработки платежей
   * @return void
   */
  public function fillParams()
  {
    $orderId = \Yii::app()->getSession()->get('PayPalOrderId');
    $this->initRequiredParams($orderId);

    $result = $this->confirmPayment();
    $ack = strtoupper($result["ACK"]);
    if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING")
    {
      $this->orderId = $orderId;
      $this->total = \Yii::app()->getSession()->get('PayPalTotal');
    }
    else
    {
      /** @var $order \pay\models\Order */
      $order = \pay\models\Order::model()->findByPk($orderId);
      \pay\components\SystemRouter::logError('Произошел отказ в проведении транзакции со стороны PayPal. ' . var_export($result, true), 0);
      $url = \Yii::app()->createAbsoluteUrl('/pay/cabinet/index', array('eventIdName' => $order->Event->IdName));
      \Yii::app()->getController()->redirect($url);
    }
  }

  private function confirmPayment()
  {
    $request = \Yii::app()->getRequest();
    $params = array(
      'TOKEN' => $request->getParam('token', false),
      'PAYERID' => $request->getParam('PayerID', false),
      'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
      'PAYMENTREQUEST_0_AMT' => \Yii::app()->getSession()->get('PayPalTotal'),
      'PAYMENTREQUEST_0_CURRENCYCODE' => 'RUB',
      'IPADDRESS' => $_SERVER['SERVER_NAME']
    );


    $request = http_build_query($params);

    $resArray = $this->requestCall("DoExpressCheckoutPayment", $request);
    return $resArray;
  }

  /**
   * Выполняет отправку пользователя на оплату в соответствующую платежную систему
   * @param int $eventId
   * @param string $orderId
   * @param int $total
   * @throws \Exception
   * @param string $orderId
   * @param int $total
   * @return array
   */
  public function processPayment($eventId, $orderId, $total)
  {
    $this->initRequiredParams($orderId);
    $total = number_format($total, 2, '.', '');
    //$totalUsd = 0.20;

    $event = \event\models\Event::model()->findByPk($eventId);
    if ($event == null)
        throw new CodeException(902, [$eventId]);

    $params = array(
      'PAYMENTREQUEST_0_AMT' => $total,
      'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
      'RETURNURL' => \Yii::app()->createAbsoluteUrl('/pay/callback/index'),
      'CANCELURL' => \Yii::app()->createAbsoluteUrl('/pay/cabinet/index', array('eventIdName' => $event->IdName)),
      'PAYMENTREQUEST_0_CURRENCYCODE' => 'RUB',
      'NOSHIPPING' => 1
    );

    $item = array(
      'L_PAYMENTREQUEST_0_NAME0' => 'Order №' . $orderId,
      'L_PAYMENTREQUEST_0_AMT0' => $total,
      'L_PAYMENTREQUEST_0_QTY0' => '1'
    );

    $request = http_build_query($params + $item);
    $result = $this->requestCall("SetExpressCheckout", $request);
    $ack = strtoupper($result["ACK"]);
    if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING')
    {
      \Yii::app()->getSession()->add('PayPalTotal', $total);
      \Yii::app()->getSession()->add('PayPalOrderId', $orderId);
      \Yii::app()->getController()->redirect($this->getPayPalUrl($result["TOKEN"]));
    }
    else
    {
      throw new \Exception('Произошла ошибка при обращении к PayPal, нужно срочно разобраться.');
    }
  }

  /**
     * @param $token
     * @return string
     */
    protected  function getPayPalUrl($token)
    {
      //return 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token);
      return 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . urlencode($token);
    }

  /**
   * @return void
   */
  public function endParseSystem()
  {
    /** @var $order \pay\models\Order */
    $order = \pay\models\Order::model()->findByPk($this->getOrderId());
    $url = \Yii::app()->createAbsoluteUrl('/pay/cabinet/return', array('eventIdName' => $order->Event->IdName));
    \Yii::app()->getController()->redirect($url);
  }


  /**
   * Function to perform the API call to PayPal using API signature
   *
   * @param string $methodName
   * @param $nvpRequest
   * @return array Returns an associtive array containing the response from the server
   */
  protected function requestCall($methodName, $nvpRequest)
  {
    $nvpRequest = $this->fillNvpRequest($methodName, $nvpRequest);
    $ch = $this->createCurlResource($nvpRequest);
    $response = curl_exec($ch);
    $nvpResArray = $this->deformatNVP($response);
    curl_close($ch);
    return $nvpResArray;
  }

  /**
   * @param $nvpRequest
   * @return resource
   */
  protected function createCurlResource($nvpRequest)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, self::Url);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpRequest);

    return $ch;
  }

  protected function fillNvpRequest($methodName, $request)
  {
    return "METHOD=" . urlencode($methodName)
      . "&VERSION=" . urlencode(self::Version)
      . "&PWD=" . urlencode($this->password)
      . "&USER=" . urlencode($this->username)
      . "&SIGNATURE=" . urlencode($this->signature)
      . "&LOCALECODE=" . urlencode(\Yii::app()->language == 'en' ? 'en_US' : 'ru_RU')
      //. '&=' . urlencode('PP-ECWizard')
      . '&' . $request;
  }

  protected function deformatNVP($nvpstr)
  {
    $intial=0;
    $nvpArray = array();
    while(strlen($nvpstr))
    {
      $keypos= strpos($nvpstr,'=');
      $valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);
      $keyval=substr($nvpstr,$intial,$keypos);
      $valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
      $nvpArray[urldecode($keyval)] =urldecode( $valval);
      $nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
    }
    return $nvpArray;
  }
}
