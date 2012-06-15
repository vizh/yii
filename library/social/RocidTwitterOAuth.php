<?php

 
class RocidTwitterOAuth
{
  /**
   * @static
   * @return TwitterOAuth
   */
  public static function GetConnection($oAuthToken = null, $oAuthTokenSecret = null)
  {
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oAuthToken, $oAuthTokenSecret);
    return $connection;
  }

  /**
   * @static
   * @return bool|mixed
   */
  public static function GetContent()
  {
    $session = Registry::GetSession();
    $accessToken = $session->get('twi_access_token');
    if ($accessToken == null)
    {
      return false;
    }

    $connection = RocidTwitterOAuth::GetConnection($accessToken['oauth_token'], $accessToken['oauth_token_secret']);

    $content = $connection->get('account/verify_credentials');

    if ($connection->http_code == 200)
    {
      return $content;
    }
    else
    {
      return false;
    }
  }

  public static function GetResultHtml($call = null)
  {
    $view = new View();
    $view->SetTemplate('success', 'main', 'connect', 'twitter', 'public');

    $view->Call = $call;

    return $view;
  }
}


$path = AutoLoader::LibraryPath . DIRECTORY_SEPARATOR . 'social' .
        DIRECTORY_SEPARATOR . 'twitteroauth' . DIRECTORY_SEPARATOR;
include_once $path . 'twitteroauth.php';
include_once $path . 'config.php';