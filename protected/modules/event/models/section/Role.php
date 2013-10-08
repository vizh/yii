<?php
namespace event\models\section;

/**
 * @property int $Id
 * @property string $Title
 * @property string $Type
 * @property int $Priority
 */
class Role extends \CActiveRecord
{
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'EventSectionRole';
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