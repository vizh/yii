<?php
namespace oauth\components\social;

class Google implements ISocial
{
    const ClientId = '251189931941-nnrvsbbek09m65om8kahvu2h9jjkedmq.apps.googleusercontent.com';

    const ClientSecret = 'HKPw-oKWP1RxIgfGVsyIGUP0';

    protected $redirectUrl = null;

    const OauthBaseUrl = 'https://accounts.google.com/o/oauth2/auth?';

    public static $CURL_OPTS = array(
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 60,
        CURLOPT_USERAGENT      => 'runetid-php'
    );

    public function __construct($redirectUrl = null)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * Делает redirect_uri
     * @return string
     */
    public function getRedirectUrl()
    {
        if( is_null($this->redirectUrl) ) {

            $redirectUrlParams = [
                'social'=>self::getSocialId()
            ];

            if (\Iframe::isFrame()) {
                $redirectUrlParams['frame'] = true;
            }

            $this->redirectUrl = \Yii::app()->getController()->createAbsoluteUrl('/oauth/social/connect', $redirectUrlParams);
           // $this->redirectUrl = \Yii::app()->createAbsoluteUrl('/oauth/social/connect', $redirectUrlParams);
        }

        return $this->redirectUrl;
    }

    /**
     * Url Oauth авторизации
     * @return string
     */
    public function getOAuthUrl()
    {
        $params = [
            'client_id'     => self::ClientId,
            'response_type' => 'code',
            'scope'         => 'email profile',
            'redirect_uri'  => $this->getRedirectUrl()
        ];

        $oauthUrl = 'https://accounts.google.com/o/oauth2/auth?'.  http_build_query($params);

        return $oauthUrl;
    }

    /**
     * Внутренний айди сервиса
     * @return string
     */
    public function getSocialId()
    {
        return self::Google;
    }

    /**
     * Данные авторизованного пользователя
     * @return Data
     * @throws \CHttpException
     */
    public function getData()
    {
        $accessToken = $this->getAccessToken();
        $params = [
            'access_token' => $accessToken->access_token
        ];
        $response = $this->makeRequest('https://www.googleapis.com/oauth2/v3/userinfo?'.http_build_query($params));
        if (isset($response->error)) {
            throw new \CHttpException(400, 'Сервис авторизации Google Accounts не отвечает');
        }
        $data = new Data();
        $data->Hash = $response->sub;
        $data->LastName = $response->family_name;
        $data->FirstName = $response->given_name;
        $data->Email = $response->email;
        return $data;
    }

    /**
     * Тайтл
     * @return string
     */
    public function getSocialTitle()
    {
        return 'Google Accounts';
    }

    /**
     * Проверяет доступ
     * @return bool
     * @throws \CHttpException
     */
    public function isHasAccess()
    {
        $code = \Yii::app()->getRequest()->getParam('code', null);
        $accessToken = $this->getAccessToken();
        if (empty($accessToken) && !empty($code)) {
            $accessToken = $this->requestAccessToken($code);
        if (isset($accessToken->error)) {
            throw new \CHttpException(400, 'Сервис авторизации Google Account не отвечает');
        }
        \Yii::app()->getSession()->add('google_access_token', $accessToken);
        }
        return !empty($code) || !empty($accessToken);
    }

    /**
     * Возвращает access_token из сессии
     * @return mixed|null
     */
    protected function getAccessToken()
    {
        return \Yii::app()->getSession()->get('google_access_token', null);
    }

    /**
     * Убиваем access_token
     */
    public function clearAccess()
    {
        \YIi::app()->getSession()->remove('google_access_token');
    }

    /**
     * Получаем access_token
     * @param $code
     * @return mixed
     */
    protected function requestAccessToken($code)
    {
        $params = array(
            'client_id' => self::ClientId,
            'client_secret' => self::ClientSecret,
            'code' => $code,
            'grant_type' => 'authorization_code'
        );

        $params['redirect_uri'] = $this->getRedirectUrl();
        return $this->makeRequest('https://accounts.google.com/o/oauth2/token?', $params);
    }

    /**
     * Запрос к сервису
     * @param $url
     * @param array $params
     * @return mixed
     * @throws \CHttpException
     */
    protected function makeRequest($url, $params = array())
    {
        $ch = curl_init();
        $opts = self::$CURL_OPTS;
        if (!empty($params)) {
          $opts[CURLOPT_POSTFIELDS] = http_build_query($params, null, '&');
        }
        $opts[CURLOPT_URL] = $url;
        curl_setopt_array($ch, $opts);
        $result = curl_exec($ch);
        if (curl_errno($ch) !== 0) {
          throw new \CHttpException(400, 'Сервис авторизации Google Account  не отвечает');
        }
        return json_decode($result);
    }
  
    public function renderScript()
    {
        echo '<script>
          if(window.opener != null && !window.opener.closed)
          {
            window.opener.oauthModuleObj.gProcess();
            window.close();
          }
          </script>';
    }

}
