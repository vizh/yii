<?php
namespace ruvents\models;


/**
 * @property int $LogId
 * @property int $OperatorId
 * @property string $Controller
 * @property string $Action
 * @property string $Request
 * @property string $Time
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
    return 'Mod_RuventsLog';
  }

  public function primaryKey()
  {
    return 'LogId';
  }
}