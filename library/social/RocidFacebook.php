<?php

class RocidFacebook
{

  const AppId = '201234113248910';
  const SecretKey = '102257e6ef534fb163c7d1e7e31ffca7';


  /**
   * @static
   * @param bool $useCookie
   * @return Facebook
   */
  public static function GetConnection()
  {
    $facebook = new Facebook(array( 'appId'  => self::AppId,
                                  'secret' => self::SecretKey,
                                  'cookie' => true,));
    return $facebook;
  }

  /**
   * @static
   * @return null|String
   */
  public static function GetUserId()
  {
    $facebook = self::GetConnection();

    $uid = null;
    $session = $facebook->getSession();
    if ($session)
    {
      try
      {
        $uid = $facebook->getUser();
      }
      catch (FacebookApiException $e)
      {
        Lib::log($e->getMessage(), CLogger::LEVEL_ERROR);
      }
    }

    return $uid;
  }

  /**
   * @static
   * @return null|array
   */
  public static function GetUserInfo()
  {
    $facebook = self::GetConnection();

    $userInfo = null;
    $user = $facebook->getUser();
    //$session = $facebook->getSession();
//    if ($_SERVER['REMOTE_ADDR'] == '82.142.129.35')
//    {
//      print_r($session);
//    }
    if ($user)
    {
      try
      {
        $userInfo = $facebook->api('/me');
      }
      catch (FacebookApiException $e)
      {
        Lib::log($e->getMessage(), CLogger::LEVEL_ERROR);
      }
    }

    return $userInfo;
  }

  public static function GetResultHtml()
  {
    $view = new View();
    $view->SetTemplate('success', 'main', 'connect', 'facebook', 'public');

    return $view;
  }

  public static function GetRootHtml()
  {
    $view = new View();
    $view->SetTemplate('fb-root', 'main', 'connect', 'facebook', 'public');

    $facebook = self::GetConnection();
    $session = $facebook->getUser();
    $view->Facebook = $facebook;
    $view->Session = $session;

    return $view;
  }

}

$path = AutoLoader::LibraryPath . DIRECTORY_SEPARATOR . 'social' .
        DIRECTORY_SEPARATOR . 'facebookapi' . DIRECTORY_SEPARATOR;
include_once $path . 'facebook.php';