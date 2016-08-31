<?php
namespace oauth\components\social;


class PayPal implements ISocial
{
    const SessionNameAccessToken = 'pp_access_token';
    const SessionNameRedirectUrl = 'pp_redirect_url';
    const ClientId = 'AeeLE56qLUqdnIgnfydBk5_cy2_m-6WRCTMGX4d1WfY4mCfR6cWzQvKCz80P60816kVMJO8mtEMQqwEj'; //'AcTEGxClf9XPZ7Xsc1WnvMLhQeVQ6SGYV4XygpArCW7QXaFvLWoO3KspYlnf';
    const ClientSecret = 'EO9rAwFqST8CDlQ0d1eO1ADiE8S3ZymgssZsDCUUn_KyYijVRAnmcqWAuvwW9yKjfcEYAQtpiDBaK-jL'; //'ELeYdBB2Rn582Re_ieZ3qKxueN3fVUgpYVbWc-gLSUv7VlyaRGXkDSOmQ3Cy';
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
        $scope = ['email', 'profile'];
        return \PayPal\Auth\Openid\PPOpenIdSession::getAuthorizationUrl(\Yii::app()->createAbsoluteUrl('/oauth/paypal/redirect'), $scope , self::ClientId,  $this->apicontext);
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