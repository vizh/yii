<?php
namespace oauth\components\social;

class Linkedin implements ISocial
{
    const APIKey = '75f5b92kztlne0';
    const Secret = 'AmZ7wL0p7M4zpi1l';
    const userToken = '19e5207b-3327-479e-bf28-a8f3a98a8953';
    const userSecret = 'ceb008e1-afdc-4f58-a533-782febd2aa83';

  
  protected $redirectUrl;
  public function __construct($redirectUrl = null)
  {
    $this->redirectUrl = $redirectUrl;
  }

  public function getOAuthUrl()
  {
    $params = array(
      'response_type'=> 'code',
      'client_id' => self::APIKey,
      'state' => '71064386e1731ff1ceb2b4667ce67b8c',
      'redirect_uri' => 'http://runet-id.com/oauth/social/connect/social/22'
    );
    //$params['redirect_uri'] = $this->redirectUrl == null ? \Yii::app()->getController()->createAbsoluteUrl('/oauth/social/connect').'/social/22' : $this->redirectUrl;
    return 'https://www.linkedin.com/uas/oauth2/authorization?' . http_build_query($params);
  }

  public function isHasAccess()
  {
    $code = \Yii::app()->getRequest()->getParam('code', null);
    $accessToken = $this->getAccessToken();
    if (empty($accessToken) && !empty($code))
    {
      $accessToken = $this->requestAccessToken($code);
      if (isset($accessToken->error))
      {
        throw new \CHttpException(400, 'Сервис авторизации LinkedIn не отвечает');
      }
      \Yii::app()->getSession()->add('LI_access_token', $accessToken);
    }
    return !empty($code) || !empty($accessToken);
  }


  public static $CURL_OPTS = array(
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 60,
    CURLOPT_USERAGENT      => 'runetid-php',
  );

  protected function makeRequest($url, $params = array())
  {
    $ch = curl_init();

    $opts = self::$CURL_OPTS;
      $authString = 'Authorization: '.$params['Authorization'];
    $headers = array($authString);
    $opts[CURLOPT_HTTPHEADER] = $headers;
    $opts[CURLOPT_URL] = $url;
    curl_setopt_array($ch, $opts);
    $result = curl_exec($ch);

    if (curl_errno($ch) !== 0)
    {
      throw new \CHttpException(400, 'Сервис авторизации LinkedIn не отвечает');
    }
    return json_decode($result);
  }

    protected function makePostRequest($url, $params = array())
    {
        $ch = curl_init();

        $opts = self::$CURL_OPTS;

        $opts[CURLOPT_POSTFIELDS] = http_build_query($params, null, '&');
        $opts[CURLOPT_URL] = $url;

        curl_setopt_array($ch, $opts);
        $result = curl_exec($ch);

        if (curl_errno($ch) !== 0)
        {
            throw new \CHttpException(400, 'Сервис авторизации LinkedIn не отвечает');
        }
        return json_decode($result);
    }


    protected function getAccessToken()
  {
    return \Yii::app()->getSession()->get('LI_access_token', null);
  }
  
  public function clearAccess()
  {
    \Yii::app()->getSession()->remove('LI_access_token');
  }

  protected function requestAccessToken($code)
  {
    $params = array(
      'grant_type' => 'authorization_code',
      'client_id' => self::APIKey,
      'code' => $code,
      'client_secret'=>self::Secret,
        'redirect_uri' => 'http://runet-id.com/oauth/social/connect/social/22'
    );
    //$params['redirect_uri'] = $this->redirectUrl == null ? \Yii::app()->getController()->createAbsoluteUrl('/oauth/social/connect').'/social/22' : $this->redirectUrl;
    return $this->makePostRequest('https://www.linkedin.com/uas/oauth2/accessToken', $params);
  }


  /**
   * @return Data
   */
  public function getData()
  {
    $accessToken = $this->getAccessToken();

    $params['Authorization'] = 'Bearer '.$accessToken->access_token;

    $response = $this->makeRequest('https://api.linkedin.com/v1/people/~?format=json', $params);


    if (isset($response->errorCode))
    {
      throw new \CHttpException(400, 'Сервис авторизации LinkedIn отвечает '.$response->message);
    }
    //$user_data = json_decode($response);

      //print_r($response); exit;

    $data = new Data();

    $data->Hash = $response->id;
    $data->UserName = $response->lastName.$response->firstName;

    $data->LastName = $response->lastName;
    $data->FirstName = $response->firstName;
    $data->Email = '';
    return $data;
  }

  public function getSocialId()
  {
    return self::Linkedin;
  }

  /**
   * @return void
   */
  public function renderScript()
  {
    echo '<script>
      if(window.opener != null && !window.opener.closed)
      {
        window.opener.oauthModuleObj.LIProcess();
        window.close();
      }
      </script>';
  }

  /**
   * @return string
   */
  public function getSocialTitle()
  {
    return 'Linkedin';
  }
}