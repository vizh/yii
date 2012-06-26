<?php

class PayPalSystem extends BaseSystem
{
  const Url = 'https://api-3t.sandbox.paypal.com/nvp';
  const Version = 89.0;

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
   * @return array
   */
  public function ProcessPayment($eventId, $orderId, $total)
  {
    $this->initRequiredParams($orderId);
    $total = number_format($total, 2, '.', '');

    $params = array(
      'PAYMENTREQUEST_0_AMT' => $total,
      'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
      'RETURNURL' => 'http://rocid.ru/return',
      'CANCELURL' => 'http://rocid.ru/cancel',
      'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
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
      Lib::Redirect($this->GetPayPalUrl($result["TOKEN"]));
    }
    else
    {
      print_r($result);
      //TODO написать реализацию для обработки ошибки обращения к PayPal
    }
  }

  /**
     * @param $token
     * @return string
     */
    protected  function GetPayPalUrl($token)
    {
      return 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token);
      //return 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . urlencode($token);
    }

  /**
   * @return void
   */
  public function EndParseSystem()
  {
    // TODO: Implement EndParseSystem() method.
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
      . "&SIGNATURE=" . urlencode($this->signature) . $request;
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
