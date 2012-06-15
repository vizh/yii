<?php
AutoLoader::Import('library.rocid.user.User');

class Group extends CActiveRecord
{
  public static $TableName = 'Mod_Group';
  
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
    return 'GroupId';
  }
  
  public function relations()
  {
    return array(   
      'User' => array(self::HAS_MANY, 'GroupUser', 'GroupId'),
    );
  }
  
  /**
  * Геттеры и сеттеры для полей
  */
  public function GetGroupId()
  {
    return $this->GroupId;
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
  
  //Name
  public function GetName()
  {
    return $this->Name;
  }
  
  public function SetName($value)
  {
    $this->Name = $value;
  }
  
  //Info
  public function GetInfo()
  {
    return $this->Info;
  }
  
  public function SetInfo($value)
  {
    $this->Info = $value;
  }
  
  //Private
  public function GetPrivate()
  {
    return $this->Private;
  }
  
  public function SetPrivate($value)
  {
    $this->Private = $value;
  }  
}