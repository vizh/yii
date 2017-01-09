<?php

namespace oauth\components\social;

class Vkontakte implements ISocial
{

    const AppId = '5612171';

    const Secret = 'PUudnl5VWcU5dk2QzLO8';

    protected $redirectUrl;

    public function __construct($redirectUrl = null)
    {
        $this->redirectUrl = $redirectUrl;
    }

    public function getOAuthUrl()
    {
        $params = array(
            'client_id' => self::AppId,
            'display' => 'touch',
            'scope' => 'offline,email'
        );
        $returnUrlParams = [];
        if (\Iframe::isFrame()) {
            $returnUrlParams['frame'] = 'true';
        }
        $params['redirect_uri'] = $this->redirectUrl == null ? \Yii::app()->getController()->createAbsoluteUrl('/oauth/social/connect', $returnUrlParams) : $this->redirectUrl;
        return 'https://oauth.vk.com/authorize?' . http_build_query($params);
    }

    public function isHasAccess()
    {
        $code = \Yii::app()->getRequest()->getParam('code', null);
        $accessToken = $this->getAccessToken();
        if (empty($accessToken) && !empty($code)) {
            $accessToken = $this->requestAccessToken($code);
            if (isset($accessToken->error)) {
                throw new \CHttpException(400, 'Сервис авторизации Vkontakte не отвечает');
            }
            \Yii::app()->getSession()->add('vk_access_token', $accessToken);
        }
        return !empty($code) || !empty($accessToken);
    }

    public static $CURL_OPTS = array(
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_USERAGENT => 'runetid-php',
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false
    );

    protected function makeRequest($url, $params = array())
    {
        $ch = curl_init();

        $opts = self::$CURL_OPTS;

        $opts[CURLOPT_POSTFIELDS] = http_build_query($params, null, '&');
        $opts[CURLOPT_URL] = $url;

        curl_setopt_array($ch, $opts);
        $result = curl_exec($ch);
        if (curl_errno($ch) !== 0) {
            throw new \CHttpException(400, 'Сервис авторизации Vkontakte не отвечает');
        }
        return json_decode($result);
    }

    protected function getAccessToken()
    {
        return \Yii::app()->getSession()->get('vk_access_token', null);
    }

    /**
     * Clear access
     */
    public function clearAccess()
    {
        \Yii::app()->getSession()->remove('vk_access_token');
    }

    /**
     * @param $code
     * @return mixed
     */
    protected function requestAccessToken($code)
    {
        $params = array(
            'client_id' => self::AppId,
            'client_secret' => self::Secret,
            'code' => $code
        );
        \Iframe::isFrame() ? $returnUrlParams['frame'] = 'true' : '';
        $params['redirect_uri'] = $this->redirectUrl == null ? \Yii::app()->getController()->createAbsoluteUrl('/oauth/social/connect', $returnUrlParams) : $this->redirectUrl;
        return $this->makeRequest('https://oauth.vk.com/access_token?' . http_build_query($params));
    }

    /**
     * @return Data
     * @throws \CHttpException
     */
    public function getData()
    {

        $accessToken = $this->getAccessToken();

        $params['uid'] = $accessToken->user_id;
        $params['fields'] = 'first_name,last_name,nickname,screen_name,sex,bdate,timezone,photo_rec,photo_big';
        $params['access_token'] = $accessToken->access_token;

        $response = $this->makeRequest('https://api.vk.com/method/getProfiles?' . http_build_query($params));
        if (!isset($response->response[0])) {
            throw new \CHttpException(400, 'Сервис авторизации Vkontakte не отвечает');
        }
        $user_data = $response->response[0];

        $data = new Data();
        $data->Hash = $user_data->uid;
        $data->UserName = $user_data->screen_name;

        $data->LastName = $user_data->last_name;
        $data->FirstName = $user_data->first_name;
        if (!empty($accessToken->email)) {
            $data->Email = $accessToken->email;
        }
        return $data;
    }

    /**
     * @return string
     */
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

    /**
     * @return string
     */
    public function getSocialTitle()
    {
        return 'Вконтакте';
    }
}