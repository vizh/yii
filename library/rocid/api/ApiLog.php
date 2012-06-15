<?php
/**
 * @property int $LogId
 * @property int $AccountId
 * @property string $Target
 * @property string $Request
 * @property int $ExecutionTime
 * @property string $ExecutionData
 * @property string $CreationTime
 */
class ApiLog extends CActiveRecord
{
  public static $TableName = 'Mod_ApiLog';

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
    return 'LogId';
  }

  public function relations()
  {
    return array(

    );
  }
}
