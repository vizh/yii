<?php

class JobAccount
{
  private static $map = array(
    1 => array(101496, 17415, 92540, 102753, 112898),
    2 => array(115523, 15648)
  );

  public function __construct($rocId)
  {
    foreach (self::$map as $accountId => $userInfo)
    {
      if (in_array($rocId, $userInfo))
      {
        $this->accountId = $accountId;
        break;
      }
    }
  }

  private $accountId = 0;
  /**
   * @return int
   */
  public function AccountId()
  {
    return $this->accountId;
  }

}