<?php
namespace oauth\components\social;

class Linkedin implements ISocial
{
    const APIKey = '785dwksq1qzrtb'; //'75f5b92kztlne0';
    const Secret = 'zwLKNmbsKRHOer8X'; //'AmZ7wL0p7M4zpi1l';
    const userToken = '19e5207b-3327-479e-bf28-a8f3a98a8953';
    const userSecret = 'ceb008e1-afdc-4f58-a533-782febd2aa83';

    const LinkedInOauthUrl = 'https://www.linkedin.com/uas/oauth2/authorization';

    const State = '71064386e1731ff1ceb2b4667ce67b8c';

    protected $redirectUrl;

    public static $CURL_OPTS = [
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_USERAGENT => 'runetid-php',
    ];

    public function __construct($redirectUrl = null)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * Урл Oauth авторизации
     * @return string
     */
    public function getOAuthUrl()
    {
        $params = [
            'response_type' => 'code',
            'client_id' => self::APIKey,
            'state' => self::State,
            'redirect_uri' => $this->makeRedirectUrl()
        ];
        return self::LinkedInOauthUrl.'?'.http_build_query($params);
    }

    /**
     * Генерирует redirect_url
     * @return string
     */
    private function makeRedirectUrl()
    {
        return \Yii::app()->getController()->createAbsoluteUrl('/oauth/social/connect');
    }

    /**
     * Проверяем авторизацию
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
                throw new \CHttpException(400, 'Сервис авторизации LinkedIn не отвечает');
            }
            \Yii::app()->getSession()->add('LI_access_token', $accessToken);
        }
        return !empty($code) || !empty($accessToken);
    }

    /**
     * Запрос к апи
     * @param $url
     * @param array $params
     * @return mixed
     * @throws \CHttpException
     */
    protected function makeRequest($url, $params = [])
    {
        $ch = curl_init();

        $opts = self::$CURL_OPTS;
        $authString = 'Authorization: '.$params['Authorization'];
        $headers = [$authString];
        $opts[CURLOPT_HTTPHEADER] = $headers;
        $opts[CURLOPT_URL] = $url;
        curl_setopt_array($ch, $opts);
        $result = curl_exec($ch);

        if (curl_errno($ch) !== 0) {
            throw new \CHttpException(400, 'Сервис авторизации LinkedIn не отвечает');
        }
        return json_decode($result);
    }

    /**
     * Пост запрос к апи
     * @param $url
     * @param array $params
     * @return mixed
     * @throws \CHttpException
     */
    protected function makePostRequest($url, $params = [])
    {
        $ch = curl_init();
        $opts = self::$CURL_OPTS;
        $opts[CURLOPT_POSTFIELDS] = http_build_query($params, null, '&');
        $opts[CURLOPT_URL] = $url;
        curl_setopt_array($ch, $opts);
        $result = curl_exec($ch);
        if (curl_errno($ch) !== 0) {
            throw new \CHttpException(400, 'Сервис авторизации LinkedIn не отвечает');
        }
        return json_decode($result);
    }

    /**
     * Access_token из сессии, если он там есть
     * @return mixed|null
     */
    protected function getAccessToken()
    {
        return \Yii::app()->getSession()->get('LI_access_token', null);
    }

    /**
     * Убиваем access_token в сессии
     */
    public function clearAccess()
    {
        \Yii::app()->getSession()->remove('LI_access_token');
    }

    protected function requestAccessToken($code)
    {
        $params = [
            'grant_type' => 'authorization_code',
            'client_id' => self::APIKey,
            'code' => $code,
            'client_secret' => self::Secret,
            'redirect_uri' => $this->makeRedirectUrl()
        ];
        return $this->makePostRequest('https://www.linkedin.com/uas/oauth2/accessToken', $params);
    }

    /**
     * @return Data
     * @throws \CHttpException
     */
    public function getData()
    {
        $accessToken = $this->getAccessToken();
        $params['Authorization'] = 'Bearer '.$accessToken->access_token;
        $response = $this->makeRequest('https://api.linkedin.com/v1/people/~?format=json', $params);
        if (isset($response->errorCode)) {
            throw new \CHttpException(400, 'Сервис авторизации LinkedIn отвечает '.$response->message);
        }
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