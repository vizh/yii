<?php
namespace oauth\components\social;

class Google implements ISocial
{
    const ClientId = '251189931941-nnrvsbbek09m65om8kahvu2h9jjkedmq.apps.googleusercontent.com';
    const ClientSecret = 'HKPw-oKWP1RxIgfGVsyIGUP0';

    //const ClientId = '467484783673-m9sim31n4l1f746irq3e7ivfjikt9fi1.apps.googleusercontent.com';
    //const ClientSecret = 'WoRL8MaNzqAiaa6jXCqwDoyE';
    //const ClientId = '749375903262-rg9ftbnn2edr5f7g4mgmp546gmu1pinp.apps.googleusercontent.com';
    //const ClientSecret = 'LbB-dTraHQc-PtPOuoi82q9s';

    public static $CURL_OPTS = array(
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 60,
        CURLOPT_USERAGENT      => 'runetid-php'
    );

    protected $redirectUrl;

    public function __construct($redirectUrl = null)
    {
        $this->redirectUrl = $this->makeRedirectUri();
    }

    /**
     * Делает redirect_uri
     * @return string
     */
    private function makeRedirectUri(){
        $url = \Yii::app()->getController()->createAbsoluteUrl('/oauth/social/connect',['social'=>self::Google, 'frame'=>'true']);
        return  $url;
    }

    /**
     * Url Oauth авторизации
     * @return string
     */
    public function getOAuthUrl()
    {
        $params = [
            'client_id' => self::ClientId,
            'response_type' => 'code',
            'scope' => 'email profile',
        ];
        $returnUrlParams = [
            'social' => $this->getSocialId(),
            'url' => ''
        ];
        \Iframe::isFrame() ? $returnUrlParams['frame'] = 'true' : '';
        $params['redirect_uri'] = $this->makeRedirectUri();
        return 'https://accounts.google.com/o/oauth2/auth?'.  http_build_query($params);
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
        $returnUrlParams = [
            'social' => $this->getSocialId(),
            'url' => ''
        ];
        \Iframe::isFrame() ? $returnUrlParams['frame'] = 'true' : '';
        $params['redirect_uri'] = $this->redirectUrl == null ? \Yii::app()->getController()->createAbsoluteUrl('/oauth/social/connect', $returnUrlParams) : $this->redirectUrl;
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
