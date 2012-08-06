<?php
namespace event\models;


/**
 * @property int $EventReportLikeId
 * @property int $ReportId
 * @property int $UserId
 * @property int $CreationTime
 */
class ReportLike extends \CActiveRecord
{
  public static $TableName = 'EventReportLike';
  
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
    return 'EventReportLikeId';
  }
  
  public function relations()
  {
    return array(
    );
  }
  
  /**
  * @return array[EventReportLike]
  */
  public static function GetEventReportLikePersonal($userId)
  {
    $EventReportLike = ReportLike::model();
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.UserId = :UserId';
    $criteria->params = array(':UserId' => $userId);
    return $EventReportLike->findAll($criteria);
  }
  
  /**
  * Добавляет в like-список доклад, если он еще не был добавлен
  * 
  * @param int $reportId
  * @param int $userId
  */
  public static function LikeIt($reportId, $userId)
  {
    $EventReportLike = ReportLike::model();
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.UserId = :UserId AND t.ReportId = :ReportId';
    $criteria->params = array(':UserId' => $userId, ':ReportId' => $reportId);
    $count = $EventReportLike->count($criteria);
    if ($count == 0)
    {
      $EventReportLike = new ReportLike();
      $EventReportLike->ReportId = $reportId;
      $EventReportLike->UserId = $userId;
      $EventReportLike->CreationTime = time();
      $EventReportLike->save();
    }
  }
  
}
