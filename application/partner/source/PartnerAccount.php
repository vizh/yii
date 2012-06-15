<?php

/**
 * @property int $AccountId
 * @property int $EventId
 * @property string $Login
 * @property string $Password
 */
class PartnerAccount extends CActiveRecord
{
  public static $TableName = 'Mod_PartnerAccount';

  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return self::$TableName;
  }

  public function primaryKey()
  {
    return 'AccountId';
  }

  /**
   * @param string $password
   * @return string
   */
  public function GetHash($password)
  {
    return md5($password);
  }
}