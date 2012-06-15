<?php

/**
 * @property int $ReportId
 * @property string $Header
 * @property string $Thesis
 * @property string $LinkPresentation
 */
class EventReports extends CActiveRecord
{
  public static $TableName = 'EventReports';
  
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
    return 'ReportId';
  }
  
  public function relations()
  {
    return array(
      'EventProgram' => array(self::BELONGS_TO, 'EventProgram', 'EventProgramId'),
    );
  }
  
  /**
  * @return EventReports
  */
  public static function GetEventReportById($id)
  {
    $EventReport = EventReports::model();    
    return $EventReport->findByPk($id);   
  }
}
