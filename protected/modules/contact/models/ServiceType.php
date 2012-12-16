<?php
namespace contact\models;

/**
 * @property int $Id
 * @property string $Title
 * @property string $Pattern
 * @property string $UrlMask
 */
class ServiceType extends \CActiveRecord
{
  /**
   * @param string $className
   * @return ServiceType
   */
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'ContactServiceType';
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