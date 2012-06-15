<?php

class GateUserIp extends CActiveRecord
{
  public static $TableName = 'GateUserIp';
  
 /**
  * @param string $className
  * @return News
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
    return 'GateUserIpId';
  }
  
  public function relations()
  {
    return array();
  }
  
  /**
  * Геттеры и сеттеры для полей
  */
  public function GetGateUserIpId()
  {
    return $this->GateUserIpId;
  }
  
  //GateUserId
  public function GetGateUserId()
  {
    return $this->GateUserId;
  }
  
  public function SetGateUserId($value)
  {
    $this->GateUserId = $value;
  }
  
  //Ip
  public function GetIp()
  {
    return $this->Ip;
  }
  
  public function SetIp($value)
  {
    $this->Ip = $value;
  }  
}