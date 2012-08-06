<?php
namespace event\models;


class Subscription extends \CActiveRecord
{
  public static $TableName = 'EventSubscription';
  
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
    return 'EventSubscriptionId';
  }
  
  public function relations()
  {
    return array(
      'Event' => array(self::HAS_ONE, 'Event', 'EventId',)
    );
  }
  
  /**
  * Геттеры и сеттеры для полей
  */
  public function GetEventSubscriptionId()
  {
    return $this->EventSubscriptionId;
  }
  
  //EventId
  public function GetEventId()
  {
    return $this->EventId;
  }
  
  public function SetEventId($value)
  {
    $this->EventId = $value;
  }
  
  //UserId
  public function GetUserId()
  {
    return $this->UserId;
  }
  
  public function SetUserId($value)
  {
    $this->UserId = $value;
  }
  
  //EventNews
  public function GetEventNews()
  {
    return $this->EventNews;
  }
  
  public function SetEventNews($value)
  {
    $this->EventNews = $value;
  }
  
  public function IsEventNews()
  {
    return ! empty($this->EventNews) && intval($this->EventNews) === 1;
  }
  
  //EventMaterials
  public function GetEventMaterials()
  {
    return $this->EventMaterials;
  }
  
  public function SetEventMaterials($value)
  {
    $this->EventMaterials = $value;
  }
  
  public function IsEventMaterials()
  {
    return ! empty($this->EventMaterials) && intval($this->EventMaterials) === 1;
  }
  
  //EventProgramInfo
  public function GetEventProgramInfo()
  {
    return $this->EventProgramInfo;
  }
  
  public function SetEventProgramInfo($value)
  {
    $this->EventProgramInfo = $value;
  }
  
  public function IsEventProgramInfo()
  {
    return ! empty($this->EventProgramInfo) && intval($this->EventProgramInfo) === 1;
  }
}