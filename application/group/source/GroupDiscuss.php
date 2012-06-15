<?php
AutoLoader::Import('library.rocid.user.User');

class GroupDiscuss extends CActiveRecord
{
  public static $TableName = 'Mod_GroupDiscuss';
  
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
    return 'DiscussId';
  }
  
  public function relations()
  {
    return array(      
      'User' => array(self::BELONGS_TO, 'User', 'UserId'),
      'Thread' => array(self::BELONGS_TO, 'GroupThread', 'ThreadId')
    );
  }  
  
  /**
  * Геттеры и сеттеры для полей
  */
  public function GetDiscussId()
  {
    return $this->DiscussId;
  }
  
  //ThreadId
  public function GetThreadId()
  {
    return $this->ThreadId;
  }
  
  public function SetThreadId($value)
  {
    $this->ThreadId = $value;
  }
  
  //ParentId
  public function GetParentId()
  {
    return $this->ParentId;
  }
  
  public function SetParentId($value)
  {
    $this->ParentId = $value;
  }
  
  //Text
  public function GetText()
  {
    return $this->Text;
  }
  
  public function SetText($value)
  {
    $this->Text = $value;
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
  
  //CreationTime
  public function GetCreationTime()
  {
    return $this->CreationTime;
  }
  
  public function SetCreationTime($value)
  {
    $this->CreationTime = $value;
  }
}