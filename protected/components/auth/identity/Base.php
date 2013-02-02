<?php
namespace application\components\auth\identity;

class Base extends \CUserIdentity
{
  protected $_id;
  
  /**
   *
   * @return int
   */
  public function getId()
  {
    return $this->_id;
  }

  /**
   * @return int
   */
  public static function GetExpire()
  {
    //days * hours * minutes * seconds
    return 180 * 24 * 60 * 60;
  }
}
