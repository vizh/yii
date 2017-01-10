<?php
namespace oauth\components\social;

use PayPal\Api\OpenIdSession;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\OpenIdTokeninfo;
use PayPal\Api\OpenIdUserinfo;

class PayPal implements ISocial
{
    const SessionNameAccessToken = 'pp_access_token';

    const SessionNameRedirectUrl = 'pp_redirect_url';

    const Scope = ['openid', 'profile', 'address', 'email', 'phone'];

    /** Live */
    const ClientId = 'AYheeeUHAWWrc7YnWfmeh86glXnNvuGjVu0cpw7daaYLiPIlOCckF6jTKi1ZN5linhA85jQYOI39mI6S';

    const ClientSecret = 'EAIM9XilaIBoYSNd_DVxjWX1OSrfYOXYVidn2vU4EFAtWmOzg-yMIvxkKQ7SxnHxU_SMbS0RITMl-pud';

    private $apiContext;

    private $redirectUrl;

    public function __construct($redirectUrl = null)
    {
        $this->redirectUrl = $redirectUrl;

        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                self::ClientId,
                self::ClientSecret
            )
        );

        $this->apiContext->setConfig(['mode'=>'live']);
    }

    /**
     * @return string
     */
    public function getOAuthUrl()
    {
        $redirectUrl = $this->redirectUrl == null ? \Yii::app()->getController()->createAbsoluteUrl('/oauth/social/connect') : $this->redirectUrl;

        \Yii::app()->getSession()->add(self::SessionNameRedirectUrl, $redirectUrl);

        if(\Iframe::isFrame()) {
            $redirectUrl = \Yii::app()->createAbsoluteUrl('/oauth/paypal/redirect', ['frame' => 'true']);
        } else {
            $redirectUrl = \Yii::app()->createAbsoluteUrl('/oauth/paypal/redirect');
        }

        $authUrl = OpenIdSession::getAuthorizationUrl(
            $redirectUrl,
            self::Scope,
            null,
            null,
            null,
            $this->apiContext
        );

        return $authUrl;
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
                throw new \CHttpException(400, 'Сервис авторизации PayPal не отвечает'.$e->getMessage());
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
        $params = [ 'access_token' => $this->getAccessToken() ];

        try {
            $userInfo = OpenIdUserinfo::getUserinfo($params, $this->apiContext);
        }
        catch(\Exception $e) {
            throw new \CHttpException(400, 'Сервис авторизации PayPal не отвечает');
        }

        $data = new Data();
        $data->Hash = $userInfo->getUserId();
        $data->LastName = $userInfo->getFamilyName();
        $data->FirstName = $userInfo->getGivenName();
        $data->Email = $userInfo->getEmail();

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
        $accessToken = OpenIdTokeninfo::createFromAuthorizationCode(['code' => $code], null, null, $this->apiContext);
        return $accessToken->access_token;
    }
}