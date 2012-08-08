<?php
namespace pay\models;

/**
 * @property int $PayLogId
 * @property string $Message
 * @property int $Code
 * @property string $Info
 * @property string $Type
 * @property string $OrderId
 * @property int $Total
 * @property string $CreationTime
 */
class PayLog extends \CActiveRecord
{
  const TypeSuccess = 'success';
  const TypeError = 'error';

  public static $TableName = 'Mod_PayLog';

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
    return 'PayLogId';
  }

  public function relations()
  {
    return array(
    );
  }
}
