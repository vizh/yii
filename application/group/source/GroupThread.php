<?php
AutoLoader::Import('library.rocid.user.User');

class GroupThread extends CActiveRecord
{
  public static $TableName = 'Mod_GroupThread';
  
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
    return 'ThreadId';
  }
  
  public function relations()
  {
    return array(      
      'User' => array(self::BELONGS_TO, 'User', 'UserId'),
      'Group' => array(self::BELONGS_TO, 'Group', 'GroupId')
    );
  }  
  
  /**
  * Геттеры и сеттеры для полей
  */
  public function GetThreadId()
  {
    return $this->ThreadId;
  }
  
  //GroupId
  public function GetGroupId()
  {
    return $this->GroupId;
  }
  
  public function SetGroupId($value)
  {
    $this->GroupId = $value;
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
  
  //CanComment
  public function GetCanComment()
  {
    return $this->CanComment;
  }
  
  public function SetCanComment($value)
  {
    $this->CanComment = $value;
  }
  
  //CanUpload
  public function GetCanUpload()
  {
    return $this->CanUpload;
  }
  
  public function SetCanUpload($value)
  {
    $this->CanUpload = $value;
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