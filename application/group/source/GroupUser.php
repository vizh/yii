<?php
AutoLoader::Import('library.rocid.user.User');

class GroupUser extends CActiveRecord
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
    return 'GroupUserId';
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
  public function GetGroupUserId()
  {
    return $this->GroupUserId;
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
  
  //UserId
  public function GetUserId()
  {
    return $this->UserId;
  }
  
  public function SetUserId($value)
  {
    $this->UserId = $value;
  }
  
  //RoleId
  public function GetRoleId()
  {
    return $this->RoleId;
  }
  
  public function SetRoleId($value)
  {
    $this->RoleId = $value;
  }
}