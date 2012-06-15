<?php
AutoLoader::Import('library.rocid.user.User');

class GroupFile extends CActiveRecord
{
  public static $TableName = 'Mod_GroupUser';
  
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
    return 'GroupFileId';
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
  public function GetGroupFileId()
  {
    return $this->GroupFileId;
  }
  
  //FileId
  public function GetFileId()
  {
    return $this->FileId;
  }
  
  public function SetFileId($value)
  {
    $this->FileId = $value;
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
  
  //DiscussId
  public function GetDiscussId()
  {
    return $this->DiscussId;
  }
  
  public function SetDiscussId($value)
  {
    $this->DiscussId = $value;
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
  
  //Text
  public function GetText()
  {
    return $this->Text;
  }
  
  public function SetText($value)
  {
    $this->Text = $value;
  }
}