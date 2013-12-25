<?php
namespace ruvents\models;


/**
 * @property int $Id
 * @property int $EventId
 * @property int $OperatorId
 * @property string $Route
 * @property string $Params
 * @property string $FullTime
 * @property string $CreationTime
 * @property int $ErrorCode
 * @property string $ErrorMessage
 */
class Log extends \CActiveRecord
{
  /**
   * @static
   * @param string $className
   * @return Log
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'RuventsLog';
  }

  public function primaryKey()
  {
    return 'Id';
  }
}