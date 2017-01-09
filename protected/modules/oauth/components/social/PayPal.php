<?php
namespace oauth\components\social;


class PayPal implements ISocial
{
    const SessionNameAccessToken = 'pp_access_token';

    const SessionNameRedirectUrl = 'pp_redirect_url';

    /** Sandbox */
    /*
    const ClientId = 'AeeLE56qLUqdnIgnfydBk5_cy2_m-6WRCTMGX4d1WfY4mCfR6cWzQvKCz80P60816kVMJO8mtEMQqwEj';
    const ClientSecret = 'EO9rAwFqST8CDlQ0d1eO1ADiE8S3ZymgssZsDCUUn_KyYijVRAnmcqWAuvwW9yKjfcEYAQtpiDBaK-jL';
    */

    /** Live */
    const ClientId = 'AYheeeUHAWWrc7YnWfmeh86glXnNvuGjVu0cpw7daaYLiPIlOCckF6jTKi1ZN5linhA85jQYOI39mI6S';
    const ClientSecret = 'EAIM9XilaIBoYSNd_DVxjWX1OSrfYOXYVidn2vU4EFAtWmOzg-yMIvxkKQ7SxnHxU_SMbS0RITMl-pud';

    //const ClientId = 'AT51Ha9TzkV_rTvttwNx0TdwmjsTfhWUanW3B4SujVW8kS-59OwvL3stU0OxBZFkbNLbQmMU22VbmeCM';
    //const ClientSecret = 'EAu0gKHiaoL76C8GNXHNMdbYxBU8OzsPeKatuxWM8S8lUBWDy8lp1IOGOAfg7S1WhSeFbJ65aWH_rB02';

    private $apicontext;

    private $redirectUrl;

    public function __construct($redirectUrl = null)
    {
        $this->redirectUrl = $redirectUrl;
        \Yii::setPathOfAlias('PayPal', \Yii::getPathOfAlias('ext.PayPal'));
        $this->apicontext  = new \PayPal\Common\PPApiContext(['mode' => 'live']);
    }

    /**
     * @return string
     */
    public function getOAuthUrl()
    {
        $redirectUrl = $this->redirectUrl == null ? \Yii::app()->getController()->createAbsoluteUrl('/oauth/social/connect') : $this->redirectUrl;

        \Yii::app()->getSession()->add(self::SessionNameRedirectUrl, $redirectUrl);
        $scope = ['openid', 'profile', 'address', 'email', 'phone'];

        if(\Iframe::isFrame()) {
            $url = \Yii::app()->createAbsoluteUrl('/oauth/paypal/redirect', ['frame' => 'true']);
        } else {
            $url = \Yii::app()->createAbsoluteUrl('/oauth/paypal/redirect');
        }

        $result =  \PayPal\Auth\Openid\PPOpenIdSession::getAuthorizationUrl($url, $scope , self::ClientId,  $this->apicontext);
        return $result;
    }

    /**
     * @return bool
     * @throws \CHttpException
     */
    public function isHasAccess()
    {
        $code = \Yii::app()->getRequest()->getParam('code', null);
        $accessToken = $this->getAccessToken();
        if (empty($accessToken) && !empty($code))
        {
            try
            {
                $accessToken = $this->requestAccessToken($code);
            }
            catch (\Exception $e)
            {
                throw new \CHttpException(400, 'Сервис авторизации PayPal не отвечает');
            }
            \Yii::app()->getSession()->add(self::SessionNameAccessToken, $accessToken);
        }
        return !empty($code) || !empty($accessToken);
    }

    /**
     * @return void
     */
    public function renderScript()
    {
        echo '<script>
        if(window.opener != null && !window.opener.closed)
        {
            window.opener.oauthModuleObj.ppProcess();
            window.close();
        }
        </script>';
    }

    /**
     * @return Data
     * @throws \CHttpException
     */
    public function getData()
    {
        $params = [
            'access_token' => $this->getAccessToken()
        ];
        try
        {
            $response = \PayPal\Auth\Openid\PPOpenIdUserinfo::getUserinfo($params,$this->apicontext);
        }
        catch(\Exception $e)
        {
            throw new \CHttpException(400, 'Сервис авторизации PayPal не отвечает');
        }

        $data = new Data();
        $data->Hash = $response->getUserId();
        $data->UserName = null;
        $data->LastName = $response->getFamilyName();
        $data->FirstName = $response->getGivenName();
        $data->Email = $response->getEmail();
        return $data;
    }

    /**
     * @return string
     */
    public function getSocialId()
    {
        return self::PayPal;
    }

    /**
     * @return string
     */
    public function getSocialTitle()
    {
        return 'PayPal';
    }

    public function clearAccess()
    {
        \Yii::app()->getSession()->remove(self::SessionNameAccessToken);
    }

    /**
     * @return mixed|null
     */
    public function getAccessToken()
    {
        return \Yii::app()->getSession()->get(self::SessionNameAccessToken, null);
    }

    /**
     * @param $code
     * @return mixed
     */
    public function requestAccessToken($code)
    {
        $params = [
            'client_id' => self::ClientId,
            'client_secret' => self::ClientSecret,
            'code' => $code
        ];
        $token = \PayPal\Auth\Openid\PPOpenIdTokeninfo::createFromAuthorizationCode($params, $this->apicontext);
        return $token->access_token;
    }
}