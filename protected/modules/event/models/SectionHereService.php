<?php
namespace event\models;

class SectionHereService extends \CActiveRecord
{
  public static $TableName = 'EventProgramHereService';
  
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
    return 'HereId';
  }
  
  public function relations()
  {
    return array(
      'Section' => array(self::BELONGS_TO, 'Section', 'EventProgramId'),
      'User' => array(self::BELONGS_TO, 'User', 'UserId'),
    );
  }
}
