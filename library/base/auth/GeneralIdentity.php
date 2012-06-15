<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 22.06.11
 * Time: 12:18
 * To change this template use File | Settings | File Templates.
 */
 
class GeneralIdentity extends CUserIdentity
{
  /**
   * @return int
   */
  public static function GetExpire()
  {
    //days * hours * minutes * seconds
    return 180 * 24 * 60 * 60;
  }

}