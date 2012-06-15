<?php
class DevutilsDb
{
  private static $oldDb = array('driver'=>'mysql', 'host'=>'localhost', 
    'dbname'=>'rocid', 'username'=>'root', 'password'=>'');
  private static $newDb = array('driver'=>'mysql', 'host'=>'localhost', 
    'dbname'=>'rocidbeta', 'username'=>'root', 'password'=>'');
  /**
  * @var CDbConnection
  */
  private static $oldConn;
  /**
  * @return CDbConnection
  */
  public static function GetOldDbConnection()
  {
    if (! self::$oldConn)
    {
      $dsn = self::$oldDb['driver'] . ':host=' . self::$oldDb['host']
        . ';dbname=' . self::$oldDb['dbname'];
      self::$oldConn = new CDbConnection($dsn, self::$oldDb['username'], self::$oldDb['password']);
      self::$oldConn->active = true;
    }
    
    return self::$oldConn;
  }
  /**
  * @var CDbConnection
  */
  private static $newConn;
  /**
  * @return CDbConnection
  */
  public static function GetNewDbConnection()
  {
    if (! self::$newConn)
    {
      $dsn = self::$newDb['driver'] . ':host=' . self::$newDb['host']
        . ';dbname=' . self::$newDb['dbname'];
      self::$newConn = new CDbConnection($dsn, self::$newDb['username'], self::$newDb['password']);
      self::$newConn->active = true;
    }
    
    return self::$newConn;
  }
}