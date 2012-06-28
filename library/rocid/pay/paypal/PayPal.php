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









  /*'----------------------------------------------------------------------------------
    * This function will take NVPString and convert it to an Associative Array and it will decode the response.
     * It is usefull to search for a particular key and displaying arrays.
     * @nvpstr is NVPString.
     * @nvpArray is Associative Array.
      ----------------------------------------------------------------------------------
     */


}
