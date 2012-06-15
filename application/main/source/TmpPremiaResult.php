<?php

/**
 * @property int $ResultId
 * @property string $Ip
 * @property string $Email
 * @property int $Result
 */
class TmpPremiaResult extends CActiveRecord
{
  public static $TableName = 'Tmp_PremiaResult';

  /**
   * @param string $className
   * @return JobTestQuestion
   */
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
    return 'ResultId';
  }

  public function relations()
  {
    return array();
  }

  /**
   * @static
   * @param $ip
   * @return CActiveRecord
   */
  public static function GetByIp($ip)
  {
    $criteria = new CDbCriteria();
    $criteria->condition = 't.Ip = :Ip';
    $criteria->params = array(':Ip' => $ip);
    return TmpPremiaResult::model()->find($criteria);
  }

  /**
   * @static
   * @param $email
   * @return CActiveRecord
   */
  public static function GetByEmail($email)
  {
    $criteria = new CDbCriteria();
    $criteria->condition = 't.Email = :Email';
    $criteria->params = array(':Email' => $email);
    return TmpPremiaResult::model()->find($criteria);
  }
}