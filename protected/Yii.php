<?php
require(dirname(__FILE__).'/../framework/YiiBase.php');

YiiBase::$classMap['application\components\WebApplication'] = dirname(__FILE__) . '/components/WebApplication.php';

class Yii extends YiiBase
{

  /**
   * @static
   * @return \application\components\WebApplication
   */
  public static function app()
  {
    return parent::app();
  }

  /**
   * Creates a Web application instance.
   * @param mixed $config application configuration.
   * If a string, it is treated as the path of the file that contains the configuration;
   * If an array, it is the actual configuration information.
   * Please make sure you specify the {@link CApplication::basePath basePath} property in the configuration,
   * which should point to the directory containing all application logic, template and data.
   * If not, the directory will be defaulted to 'protected'.
   * @return CWebApplication
   */
  public static function createWebApplication($config=null)
  {
    return self::createApplication('\application\components\WebApplication',$config);
  }

  public static function PublicPath()
  {
    return $_SERVER['DOCUMENT_ROOT'];
  }
}