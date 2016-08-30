<?php

namespace oauth\components\social;

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;

class Facebook implements ISocial
{
    const AppId = 529362707269912; // 201234113248910;
    const Secret = 'b345ebde1564caa6f022fcd848fac252'; //'102257e6ef534fb163c7d1e7e31ffca7';

    const SESSION_TOKEN_NAME = 'fb_access_token';

    private $redirectLoginHelper;

    /** @var \Facebook */
    protected $connection = null;

    public function __construct($redirectUrl = null)
    {
        if ($redirectUrl === null) {
            $redirectUrl = \Yii::app()->getController()->createAbsoluteUrl('/oauth/social/request');
        }
        FacebookSession::setDefaultApplication(static::AppId,static::Secret);
        $this->redirectLoginHelper = new FacebookRedirectLoginHelper($redirectUrl);
    }

    /**
     * @return string
     */

    public function getOAuthUrl()
    {
        return $this->redirectLoginHelper->getLoginUrl();
    }

    /**
     * @return bool
     * @throws \CHttpException
     *
     * Проверка доступа
     */

    public function isHasAccess()
    {
        $token = $this->getAccessToken();
        if (empty($token)) {
            try {
                $session = $this->redirectLoginHelper->getSessionFromRedirect();
            } catch(FacebookRequestException $ex) {
                throw new \CHttpException(400, 'Сервис авторизации FB не отвечает'.$ex);
            } catch(\Exception $ex) {
                throw new \CHttpException(400, 'Сервис авторизации FB не отвечает'.$ex);
            }
            if ($session) {
                \Yii::app()->getSession()->add(static::SESSION_TOKEN_NAME, $session->getToken());
            }
        }
        return !empty($token);
    }

    /**
     * @return mixed
     */
    protected function getAccessToken()
    {
        return \Yii::app()->getSession()->get(static::SESSION_TOKEN_NAME, null);
    }

    /**
     *  remove token
     */
    public function clearAccess()
    {
        \Yii::app()->getSession()->remove(static::SESSION_TOKEN_NAME);
    }

    /**
     * @return Data
     */

    public function getData()
    {
        $session = new FacebookSession($this->getAccessToken());
        if ($session)
        {
            $request = new FacebookRequest($session, 'GET', '/me');
            $response = $request->execute();
            $graphObject = $response->getGraphObject();
            $data = new Data();
            $data->Hash = $graphObject->getProperty('id');
            $data->UserName = $graphObject->getProperty('name');
            $data->LastName = $graphObject->getProperty('last_name');
            $data->FirstName = $graphObject->getProperty('first_name');
            $data->Email = $graphObject->getProperty('email');
            return $data;
        }
    }


    /**
     * @return string
     */
    public function getSocialId()
    {
        return self::Facebook;
    }

    /**
     * @return void
     */
    public function renderScript()
    {
        //empty for FB
    }

    /**
     * @return string
     */
    public function getSocialTitle()
    {
        return 'Facebook';
    }
}

