<?php
class UserSession extends CActiveRecord
{
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'UserSession';
  }
  
  public function primaryKey()
  {
    return 'SessionId';
  }
  
  public function relations()
  {
    return array(
      'User' => array(self::BELONGS_TO, 'User', 'UserId')      
    );
  } 
    
}