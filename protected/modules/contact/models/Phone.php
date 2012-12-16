<?php
namespace contact\models;

/**
 * @property int $Id
 * @property string $CountryCode
 * @property string $CityCode
 * @property string $Phone
 * @property string $Addon
 * @property string $Type
 */
class Phone extends \CActiveRecord
{
  /**
   * @param string $className
   * @return Phone
   */
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'ContactPhone';
  }
  
  public function primaryKey()
  {
    return 'Id';
  }
  
  public function relations()
  {
    return array();
  }
}