<?php
namespace oauth\components\social;

class Vkontakte implements ISocial
{
  const AppId = '3440645';
  const Secret = 'i1jAuObSVjiwgYRysVm3';

  public function getOAuthUrl()
  {
    $params = array(
      'client_id' => self::AppId,
      'redirect_uri' => \Yii::app()->getController()->createAbsoluteUrl('/oauth/social/connect'),
      'display' => 'touch',
      'scope' => 'offline,email'
    );

    return 'https://oauth.vk.com/authorize?' . http_build_query($params);
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
        throw new \CHttpException(400, 'Сервис авторизации Vkontakte не отвечает');
      }
      \Yii::app()->getSession()->add('vk_access_token', $accessToken);
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

    $opts[CURLOPT_POSTFIELDS] = http_build_query($params, null, '&');
    $opts[CURLOPT_URL] = $url;

    curl_setopt_array($ch, $opts);
    $result = curl_exec($ch);

    if (curl_errno($ch) !== 0)
    {
      throw new \CHttpException(400, 'Сервис авторизации Vkontakte не отвечает');
    }

    return json_decode($result);
  }

  protected function getAccessToken()
  {
    return \Yii::app()->getSession()->get('vk_access_token', null);
  }

  protected function requestAccessToken($code)
  {
    $params = array(
      'client_id' => self::AppId,
      'client_secret' => self::Secret,
      'code' => $code,
      'redirect_uri' => \Yii::app()->getController()->createAbsoluteUrl('/oauth/social/connect')
    );

    return $this->makeRequest('https://oauth.vk.com/access_token?'.http_build_query($params));
  }


  /**
   * @return Data
   */
  public function getData()
  {
    $accessToken = $this->getAccessToken();

    $params['uid'] = $accessToken->user_id;
    $params['fields'] = 'first_name,last_name,nickname,screen_name,sex,bdate,timezone,photo_rec,photo_big';
    $params['access_token'] = $accessToken->access_token;

    $response = $this->makeRequest('https://api.vk.com/method/getProfiles?'.http_build_query($params));
    if (!isset($response->response[0]))
    {
      throw new \CHttpException(400, 'Сервис авторизации Vkontakte не отвечает');
    }
    $user_data = $response->response[0];

    $data = new Data();

    $data->Hash = $user_data->uid;
    $data->UserName = $user_data->screen_name;

    $data->LastName = $user_data->last_name;
    $data->FirstName = $user_data->first_name;
    $data->Email = '';
    return $data;
  }

  public function getSocialId()
  {
    return self::Vkontakte;
  }

  /**
   * @return void
   */
  public function renderScript()
  {
    echo '<script>
      if(window.opener != null && !window.opener.closed)
      {
        window.opener.oauthModuleObj.vkProcess();
        window.close();
      }
      </script>';
  }
}