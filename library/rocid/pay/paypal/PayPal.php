<?php


class PayPal
{
  const Version = 89.0;

  protected $username;
  protected $password;
  protected $signature;

  protected $sBNCode = 'PP-ECWizard';

  /**
   * @param string $username
   * @param string $password
   * @param string $signature
   */
  public function __construct($username, $password, $signature)
  {
    $this->username = $username;
    $this->password = $password;
    $this->signature = $signature;
  }

  /**
   * @var bool
   */
  protected $sandboxEnable = false;
  /**
   * @param bool $sandboxEnable
   */
  public function SetSandboxEnable($sandboxEnable)
  {
    $this->sandboxEnable = $sandboxEnable;
  }
  /**
   * @return bool
   */
  public function GetSandboxEnable()
  {
    return $this->sandboxEnable;
  }

  /**
   * @return string
   */
  public function GetEndPointUrl()
  {
    return $this->sandboxEnable ? 'https://api-3t.sandbox.paypal.com/nvp' : 'https://api-3t.paypal.com/nvp';
  }

  /**
   * @param $token
   * @return string
   */
  public function GetPayPalUrl($token)
  {
    return ($this->sandboxEnable ? 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token='
      : 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=') . urlencode($token);
  }

  /* An express checkout transaction starts with a token, that
      identifies to PayPal your transaction
      In this example, when the script sees a token, the script
      knows that the buyer has already authorized payment through
      paypal.  If no token was found, the action is to send the buyer
      to PayPal to first authorize payment
      */

  /*
   '-------------------------------------------------------------------------------------------------------------------------------------------
   ' Purpose: 	Prepares the parameters for the SetExpressCheckout API Call.
   ' Inputs:
   '		paymentAmount:  	Total value of the shopping cart
   '		currencyCodeType: 	Currency code value the PayPal API
   '		paymentType: 		paymentType has to be one of the following values: Sale or Order or Authorization
   '		returnURL:			the page where buyers return to after they are done with the payment review on PayPal
   '		cancelURL:			the page where buyers return to when they cancel the payment review on PayPal
   '--------------------------------------------------------------------------------------------------------------------------------------------
   */
  public function CallShortcutExpressCheckout( $paymentAmount, $currencyCodeType, $paymentType, $returnURL, $cancelURL)
  {
    //------------------------------------------------------------------------------------------------------------------------------------
    // Construct the parameter string that describes the SetExpressCheckout API call in the shortcut implementation

    $nvpstr="&PAYMENTREQUEST_0_AMT=". $paymentAmount;
    $nvpstr = $nvpstr . "&PAYMENTREQUEST_0_PAYMENTACTION=" . $paymentType;
    $nvpstr = $nvpstr . "&RETURNURL=" . urlencode($returnURL);
    $nvpstr = $nvpstr . "&CANCELURL=" . urlencode($cancelURL);
    $nvpstr = $nvpstr . "&PAYMENTREQUEST_0_CURRENCYCODE=" . $currencyCodeType;
    $nvpstr = $nvpstr . '&NOSHIPPING=1';

    $_SESSION["currencyCodeType"] = $currencyCodeType;
    $_SESSION["PaymentType"] = $paymentType;

    //'---------------------------------------------------------------------------------------------------------------
    //' Make the API call to PayPal
    //' If the API call succeded, then redirect the buyer to PayPal to begin to authorize payment.
    //' If an error occured, show the resulting errors
    //'---------------------------------------------------------------------------------------------------------------
    $resArray = $this->hashCall("SetExpressCheckout", $nvpstr);
    $ack = strtoupper($resArray["ACK"]);
    if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")
    {
      $token = urldecode($resArray["TOKEN"]);
      $_SESSION['TOKEN']=$token;
    }

    return $resArray;
  }

  function ConfirmPayment($token, $payerID, $paymentAmount, $currencyCodeType, $paymentType)
  {
    /* Gather the information to make the final call to
           finalize the PayPal payment.  The variable nvpstr
           holds the name value pairs
           */


    //Format the other parameters that were stored in the session from the previous calls

    $token = urlencode($token);
    $currencyCodeType = urlencode($currencyCodeType);
    $payerID = urlencode($payerID);

    $serverName 		= urlencode($_SERVER['SERVER_NAME']);

    $nvpstr  = '&TOKEN=' . $token . '&PAYERID=' . $payerID . '&PAYMENTREQUEST_0_PAYMENTACTION=' . $paymentType . '&PAYMENTREQUEST_0_AMT=' . $paymentAmount;
    $nvpstr .= '&PAYMENTREQUEST_0_CURRENCYCODE=' . $currencyCodeType . '&IPADDRESS=' . $serverName;

    /* Make the call to PayPal to finalize payment
            If an error occured, show the resulting errors
            */
    $resArray = $this->hashCall("DoExpressCheckoutPayment", $nvpstr);

    return $resArray;
  }

  /**
   * Function to perform the API call to PayPal using API signature
   *
   * @param string $methodName
   * @param string $nvpStr
   * @return array Returns an associtive array containing the response from the server
   */
  protected function hashCall($methodName, $nvpStr)
  {
    //setting the curl parameters.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->GetEndPointUrl());
    curl_setopt($ch, CURLOPT_VERBOSE, 1);

    //turning off the server and peer verification(TrustManager Concept).
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POST, 1);

    //NVPRequest for submitting to server
    $nvpreq="METHOD=" . urlencode($methodName) . "&VERSION=" . urlencode(self::Version) . "&PWD=" . urlencode($this->password) . "&USER=" . urlencode($this->username) . "&SIGNATURE=" . urlencode($this->signature) . $nvpStr . "&BUTTONSOURCE=" . urlencode($this->sBNCode);

    //setting the nvpreq as POST FIELD to curl
    curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

    //getting response from server
    $response = curl_exec($ch);

    //convrting NVPResponse to an Associative Array
    $nvpResArray = $this->deformatNVP($response);
    $nvpReqArray = $this->deformatNVP($nvpreq);
    $_SESSION['nvpReqArray'] = $nvpReqArray;

    if (curl_errno($ch))
    {
      // moving to display page to display curl errors
      $_SESSION['curl_error_no'] = curl_errno($ch) ;
      $_SESSION['curl_error_msg'] = curl_error($ch);

      //Execute the Error handling module to display errors.
    }
    else
    {
      //closing the curl
      curl_close($ch);
    }

    return $nvpResArray;
  }


  /*'----------------------------------------------------------------------------------
    * This function will take NVPString and convert it to an Associative Array and it will decode the response.
     * It is usefull to search for a particular key and displaying arrays.
     * @nvpstr is NVPString.
     * @nvpArray is Associative Array.
      ----------------------------------------------------------------------------------
     */
  protected function deformatNVP($nvpstr)
  {
    $intial=0;
    $nvpArray = array();

    while(strlen($nvpstr))
    {
      //postion of Key
      $keypos= strpos($nvpstr,'=');
      //position of value
      $valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);

      /*getting the Key and Value values and storing in a Associative Array*/
      $keyval=substr($nvpstr,$intial,$keypos);
      $valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
      //decoding the respose
      $nvpArray[urldecode($keyval)] =urldecode( $valval);
      $nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
    }
    return $nvpArray;
  }

}
