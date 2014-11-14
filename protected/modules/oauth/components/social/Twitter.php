<?php
namespace oauth\components\social;

use oauth\components\exceptions\TwitterException;

class Twitter implements ISocial
{
    const Key = '2cfKI2ZXUhuAPpiTaNDOK97YL';
    const Secret = 'wuIgCtwVUVvI4USGLnyVLNZPZEWgXZLMSvfrcyqiBS5Ry6yVdX';

    const TEMPORARY_NAME = 'twitter_temporary_credentials';
    const PERMANENT_NAME = 'twitter_token_credentials';
    const VERIFIER_NAME = 'oauth_verifier';

    /**
     * @param array $credentials
     * @return \TwitterOAuth
     */
    public function createConnection($credentials = [])
    {
        if (empty($credentials)) {
            return new \TwitterOAuth(self::Key, self::Secret);
        } else {
            return new \TwitterOAuth(self::Key, self::Secret, $credentials['oauth_token'], $credentials['oauth_token_secret']);
        }
    }

    public function getOAuthUrl()
    {
        $connection = $this->createConnection();
        $callBackUrl = \Yii::app()->request->hostInfo . \Yii::app()->request->url;
        $temporaryCredentials = $connection->getRequestToken($callBackUrl);

        $this->checkResponse($connection, $temporaryCredentials);
        \Yii::app()->session->add(static::TEMPORARY_NAME, $temporaryCredentials);

        return $connection->getAuthorizeURL($temporaryCredentials, false);
    }

    public function isHasAccess()
    {
        $tokenCredentials = \Yii::app()->getSession()->get(static::PERMANENT_NAME, null);
        $verifier = \Yii::app()->request->getParam(static::VERIFIER_NAME, null);
        if (empty($tokenCredentials) && !empty($verifier)) {
            $temporaryCredentials = \Yii::app()->getSession()->get(static::TEMPORARY_NAME);
            $connection = $this->createConnection($temporaryCredentials);
            $tokenCredentials = $connection->getAccessToken($verifier);

            $this->checkResponse($connection, $tokenCredentials);

            \Yii::app()->session->add(static::PERMANENT_NAME, $tokenCredentials);
            \Yii::app()->session->remove(static::TEMPORARY_NAME);
        }
        return !empty($tokenCredentials) || !empty($verifier);
    }

    public function getData()
    {
        $tokenCredentials = \Yii::app()->getSession()->get(static::PERMANENT_NAME, null);

        $connection = $this->createConnection($tokenCredentials);
        $account = $connection->get('account/verify_credentials');

        $this->checkResponse($connection, $account);

        $data = new Data();

        $data->Hash = $account->id;
        $data->UserName = $account->screen_name;

        $nameParts =  explode(' ' , $account->name);
        $data->LastName = isset($nameParts[0]) ? $nameParts[0] : '';
        $data->FirstName = isset($nameParts[1]) ? $nameParts[1] : '';
        $data->Email = '';

        return $data;
    }

    public function getSocialId()
    {
        return self::Twitter;
    }

    private function checkResponse($connection, $data)
    {
        if (!empty($data) && isset($data->errors))
            throw new TwitterException('', $data->errors);

        if ($connection->http_code != 200)
            throw new TwitterException('Не верный http статус ответа: ' . $connection->http_code);
    }

    /**
     * @return void
     */
    public function renderScript()
    {
        echo '<script>
      if(window.opener != null && !window.opener.closed)
      {
        window.opener.oauthModuleObj.twiProcess();
        window.close();
      }
      </script>';
    }

    /**
     * @return string
     */
    public function getSocialTitle()
    {
        return 'Twitter';
    }

    public function clearAccess()
    {
        ;
    }
}

require dirname(__FILE__) . '/twitter/twitteroauth.php';
