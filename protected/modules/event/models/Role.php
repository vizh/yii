<?php
namespace event\models;

/**
 * @property int $Id
 * @property string $Code
 * @property string $Title
 * @property int $Priority
 */
class Role extends \CActiveRecord
{

  /**
   * @param string $className
   * @return Role
   */
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'EventRole';
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