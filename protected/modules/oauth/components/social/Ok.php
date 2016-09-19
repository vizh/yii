<?php
namespace oauth\components\social;

class Ok implements ISocial
{
    const ClientId = '1248222208';

    const ClientSecret = 'C3D6190EB2330F0F9D66DB8D';

    const PublicKey = 'CBANFHGLEBABABABA';

    public function __construct($redirectUrl = null)
    {
        $this->redirectUrl = $redirectUrl;
    }

    public static $CURL_OPTS = array(
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_USERAGENT => 'runetid-php',
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false
    );

    public function getOAuthUrl()
    {
        $url = 'http://www.odnoklassniki.ru/oauth/authorize';
        $returnUrlParams = [];
        if (\Iframe::isFrame()) {
            $returnUrlParams['frame'] = 'true';
        }
        $params = array(
            'client_id'     => self::ClientId,
            'response_type' => 'code',
            'redirect_uri'  => $this->redirectUrl == null ? \Yii::app()->getController()->createAbsoluteUrl('/oauth/social/connect', $returnUrlParams) : $this->redirectUrl
        );

        return $url."?".http_build_query($params);
    }

    public function isHasAccess()
    {
        $code = \Yii::app()->getRequest()->getParam('code', null);
        $accessToken = $this->getAccessToken();
        if (empty($accessToken) && !empty($code)) {
            $accessToken = $this->requestAccessToken($code);
            if (isset($accessToken->error)) {
                throw new \CHttpException(400, 'Сервис авторизации Odnoklassniki не отвечает');
            }
            \Yii::app()->getSession()->add('ok_access_token', $accessToken);
        }
        return !empty($code) || !empty($accessToken);
    }

    protected function requestAccessToken($code)
    {

        $url = 'http://api.odnoklassniki.ru/oauth/token.do?';

        $returnUrlParams = [];
        \Iframe::isFrame() ? $returnUrlParams['frame'] = 'true' : '';

        $params = [
            'code' => $code,
            'redirect_uri' => $this->redirectUrl == null ? \Yii::app()->getController()->createAbsoluteUrl('/oauth/social/connect', $returnUrlParams) : $this->redirectUrl,
            'grant_type' => 'authorization_code',
            'client_id' => self::ClientId,
            'client_secret' => self::ClientSecret
        ];

        return $this->makeRequest($url . http_build_query($params));
    }

    protected function makeRequest($url, $params = array())
    {
        $ch = curl_init();
        $opts = self::$CURL_OPTS;
        $opts[CURLOPT_POSTFIELDS] = http_build_query($params, null, '&');
        $opts[CURLOPT_URL] = $url;

        curl_setopt_array($ch, $opts);
        $result = curl_exec($ch);
        if (curl_errno($ch) !== 0) {
            throw new \CHttpException(400, 'Сервис авторизации Odnoklassniki не отвечает');
        }
        return json_decode($result);
    }

    public function getAccessToken(){
        return \Yii::app()->getSession()->get('ok_access_token', null);
    }

    public function getSocialId()
    {
        return self::Ok;
    }

    public function getData(){

        $accessToken = $this->getAccessToken();
        $aToken = $accessToken->access_token;

        if ($aToken && self::PublicKey) {

            $sign = md5("application_key=".self::PublicKey."format=jsonmethod=users.getCurrentUser".md5($aToken.self::ClientSecret));

            $params = array(
                'method'          => 'users.getCurrentUser',
                'access_token'    => $aToken,
                'application_key' => self::PublicKey,
                'format'          => 'json',
                'sig'             => $sign
            );

            $userInfo = $this->makeRequest('http://api.odnoklassniki.ru/fb.do', $params);

            $data = new Data();
            $data->Hash = $userInfo->uid;
            $data->UserName = $userInfo->name;
            $data->LastName = $userInfo->last_name;
            $data->FirstName = $userInfo->first_name;
            if (!empty($accessToken->email)) {
                $data->Email = $accessToken->email;
            }else
                $data->Email = '';
            return $data;
        }

        return null;
    }

    public function clearAccess(){
        \Yii::app()->getSession()->remove('ok_access_token');
    }

    /**
     * @return void
     */
    public function renderScript()
    {
        echo '<script>
        if(window.opener != null && !window.opener.closed){
            window.opener.oauthModuleObj.OkProcess();
            window.close();
        }
        </script>';
    }

    /**
     * @return string
     */
    public function getSocialTitle()
    {
        return 'Одноклассники';
    }
}