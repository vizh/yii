<?php
class Timer
{
  const Debug = 1;
  
  private static $startTime = 0;
  
  public static function StartTimer()
  {
    self::$startTime = SCRIPT_BEGIN_TIME;
  }
  
  public static function ShowTimeStamp($message)
  {
    if (self::Debug === 1)
    {
      $dTime = microtime(true) - self::$startTime;
      echo $message . ' : ' . $dTime . '<br/>';
    }
  }
  
}
