<?php
AutoLoader::Import('library.rocid.settings.*');

class Cookie
{
  private static $domain = null;
  /**
   * @static
   * @param string $domain
   * @return void
   */
  public static function SetDomain($domain)
  {
    self::$domain = $domain;
  }

  /**
   * @static
   * @param string $name
   * @return mixed|null
   */
  public static function Get($name)
  {
    return (isset(Yii::app()->request->cookies[$name]->value)) ? Yii::app()->request->cookies[$name]->value : null;
  }

  /**
   * @static
   * @param CHttpCookie $cookie
   * @return void
   */
  public static function Set($cookie)
  {
    if (! empty(self::$domain))
    {
      $cookie->domain = self::$domain;
    }
    Yii::app()->request->cookies[$cookie->name] = $cookie;
  }

  /**
   * @static
   * @param string $name
   * @return void
   */
  public static function Delete($name)
  {
    unset(Yii::app()->request->cookies[$name]);
  }

  /**
   * @static
   * @return void
   */
  public static function Clear()
  {
    Yii::app()->request->cookies->clear();
  }

}