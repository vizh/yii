<?php
AutoLoader::Import('library.rocid.tag.*');

class TagMap extends CActiveRecord
{
  public static $TableName = 'Core_TagMap';
  
  /**
  * @param string $className
  * @return User
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
    return 'TagMapId';
  }
  
  public function relations()
  {
    return array(
      'Tag' => array(self::BELONGS_TO, 'Tag', 'TagId'),
    );
  }
  
  /**
  * Геттеры и сеттеры для полей
  */
  public function GetTagMapId()
  {
    return $this->TagMapId;
  }
  
  //TagId
  public function GetTagId()
  {
    return $this->TagId;
  }
  
  public function SetTagId($value)
  {
    $this->TagId = $value;
  }
  
  //ContentId
  public function GetContentId()
  {
    return $this->ContentId;
  }
  
  public function SetContentId($value)
  {
    $this->ContentId = $value;
  }
  
  //ContentType
  public function GetContentType()
  {
    return $this->ContentType;
  }
  
  public function SetContentType($value)
  {
    $this->ContentType = $value;
  }
}
