<?php

class GateLog extends CActiveRecord
{
  public static $TableName = 'GateLog';
  
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
    return 'GateLogId';
  }
  
  public function relations()
  {
    return array(   
      'User' => array(self::HAS_ONE, 'GateUser', 'GateUserId'),
    );
  }
  
  /**
  * Геттеры и сеттеры для полей
  */
  public function GetGateLogId()
  {
    return $this->GateLogId;
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
  
  //Time
  public function GetTime()
  {
    return $this->Time;
  }
  
  public function SetTime($value)
  {
    $this->Time = $value;
  }
  
  //IncomingData
  public function GetIncomingData()
  {
    return $this->IncomingData;
  }
  
  public function SetIncomingData($value)
  {
    $this->IncomingData = $value;
  }
  
  //Action
  public function GetAction()
  {
    return $this->Action;
  }
  
  public function SetAction($value)
  {
    $this->Action = $value;
  }  
}