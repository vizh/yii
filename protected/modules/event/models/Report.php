<?php
namespace event\models;

/**
 * @property int $ReportId
 * @property string $Header
 * @property string $Thesis
 * @property string $LinkPresentation
 */
class Report extends \CActiveRecord
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
   * @param $id
   * @return Report
   */
  public static function GetEventReportById($id)
  {
    $EventReport = Report::model();
    return $EventReport->findByPk($id);   
  }
}
