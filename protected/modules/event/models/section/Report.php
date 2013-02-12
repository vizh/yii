<?php
namespace event\models\section;

/**
 * @property int $Id
 * @property string $Title
 * @property string $Thesis
 * @property string $Url
 */
class Report extends \CActiveRecord
{

  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'EventSectionReport';
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