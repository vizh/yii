<?php
class UserActivity extends CActiveRecord
{
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'UserActivity';
  }
  
  public function primaryKey()
  {
    return 'ActivityId';
  }
  
  public function relations()
  {
    return array(
      
    );
  }
}