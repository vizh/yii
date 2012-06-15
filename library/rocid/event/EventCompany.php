<?php
class EventCompany extends CActiveRecord
{
  public static $TableName = 'EventCompany';
  
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
    return 'EventCompanyId';
  }
  
  public function relations()
  {
    return array(
      'Event' => array(self::BELONGS_TO, 'Event', 'EventId'),
    );
  }
  
  /**
  * @return Event
  */
  public function GetEvent()
  {
    return $this->Event;
  }
}