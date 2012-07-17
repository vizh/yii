<?php
require(dirname(__FILE__).'/../framework/YiiBase.php');

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
}