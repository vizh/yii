<?php
namespace oauth\components\social;

class Twitter implements ISocial
{
  const Key = '2cfKI2ZXUhuAPpiTaNDOK97YL';
  const Secret = 'wuIgCtwVUVvI4USGLnyVLNZPZEWgXZLMSvfrcyqiBS5Ry6yVdX';

  /** @var \tmhOAuth */
  protected $connection = null;


  public function getConnection()
  {
    if ($this->connection == null)
    {
      $this->connection = new \tmhOAuth(array(
        'consumer_key' => self::Key,
        'consumer_secret' => self::Secret,
        'curl_ssl_verifypeer' => false,
        'oauth_version' => '1.1'
      ));
    }

    return $this->connection;
  }

  public function resetConnection()
  {
    $this->connection = null;
  }


  public function getOAuthUrl()
  {
    $params = array(
      'oauth_callback' => \tmhUtilities::php_self(false),
      'x_auth_access_type' => 'read'
    );

    $code = $this->getConnection()->request('POST', $this->getConnection()->url('oauth/request_token', ''), $params);


      var_dump($this->getConnection());
      exit;
    if ($code == 200)
    {
      $oauth = $this->getConnection()->extract_params($this->getConnection()->response['response']);
      \Yii::app()->session->add('oauth', $oauth);
      return $this->getConnection()->url('oauth/authenticate', '') . "?oauth_token={$oauth['oauth_token']}";
    }
    else
    {
      throw new \CHttpException(400, 'Сервис авторизации Twitter не отвечает');
    }
  }

  public function isHasAccess()
  {
    $accessToken = \Yii::app()->getSession()->get('access_token', null);
    $verifier = \Yii::app()->request->getParam('oauth_verifier', null);
    if (empty($accessToken) && !empty($verifier))
    {
      $oauth = \Yii::app()->getSession()->get('oauth');
      $this->getConnection()->config['user_token'] = $oauth['oauth_token'];
      $this->getConnection()->config['user_secret'] = $oauth['oauth_token_secret'];

      $code = $this->getConnection()->request(
        'POST',
        $this->getConnection()->url('oauth/access_token', ''),
        array('oauth_verifier' => \Yii::app()->request->getParam('oauth_verifier', null))
      );

      if ($code == 200)
      {
        $accessToken = $this->getConnection()->extract_params($this->getConnection()->response['response']);
        \Yii::app()->session->add('access_token', $accessToken);
        \Yii::app()->session->remove('oauth');
      }
      else
      {
        throw new \CHttpException(400, 'Сервис авторизации Twitter не отвечает');
      }
    }
    return !empty($accessToken) || !empty($verifier);
  }

  public function getData()
  {
    $accessToken = \Yii::app()->getSession()->get('access_token', null);

    $this->resetConnection();
    $this->getConnection()->config['user_token'] = $accessToken['oauth_token'];
    $this->getConnection()->config['user_secret'] = $accessToken['oauth_token_secret'];

    $code = $this->getConnection()->request('GET', $this->getConnection()->url('1.1/account/verify_credentials.json'));

    if ($code == 200)
    {
      $user_profile = json_decode($this->getConnection()->response['response']);

      $data = new Data();

      $data->Hash = $user_profile->id;
      $data->UserName = $user_profile->screen_name;

      $nameParts =  explode(' ' , $user_profile->name);
      $data->LastName = isset($nameParts[0]) ? $nameParts[0] : '';
      $data->FirstName = isset($nameParts[1]) ? $nameParts[1] : '';
      $data->Email = '';

      return $data;
    }
    else
    {
      throw new \CHttpException(400, 'Сервис авторизации Twitter не отвечает');
    }
  }

  public function getSocialId()
  {
    return self::Twitter;
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

require dirname(__FILE__) . '/twitter/tmhOAuth.php';
require dirname(__FILE__) . '/twitter/tmhUtilities.php';

function outputError($tmhOAuth) {
  echo 'Error: ' . $tmhOAuth->response['response'] . PHP_EOL;
  \tmhUtilities::pr($tmhOAuth);
}