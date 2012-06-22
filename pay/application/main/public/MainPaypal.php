<?php
AutoLoader::Import('library.rocid.pay.paypal.*');

class MainPaypal extends PayCommand
{

  /**
   * Основные действия комманды
   * @param int $eventId
   * @return void
   */
  protected function doExecute($eventId = 0)
  {
    $paypal = new PayPal('n_1340289183_biz_api1.internetmediaholding.com', '1340289210', 'ASotwUFhF77eR9f46CC9ZDcSDh5XAL4B5T88RqduJwvavxHmvkhlZSvG');
    $paypal->SetSandboxEnable(true);


    $url = RouteRegistry::GetUrl('main', '', 'paypal', array('eventId' => $eventId));
    $resArray = $paypal->CallShortcutExpressCheckout('1.00', 'USD', 'Sale', $url, $url.'?cancel=1');
    $ack = strtoupper($resArray["ACK"]);
    if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")
    {
      //print_r($resArray);
      Lib::Redirect($paypal->GetPayPalUrl($resArray["TOKEN"]));
    }
    else
    {
    	//Display a user friendly Error on the page using any of the following error information returned by PayPal
    	$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
    	$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
    	$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
    	$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

    	echo "SetExpressCheckout API call failed. <br>";
    	echo "Detailed Error Message: " . $ErrorLongMsg;
    	echo "<br>Short Error Message: " . $ErrorShortMsg;
    	echo "<br>Error Code: " . $ErrorCode;
    	echo "<br>Error Severity Code: " . $ErrorSeverityCode . '<br><br>';

    }
  }
}
