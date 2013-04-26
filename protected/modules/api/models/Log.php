<?php
namespace api\models;

/**
 * @property int $Id
 * @property int $AccountId
 * @property string $Route
 * @property string $Params
 * @property float $DbTime
 * @property float $FullTime
 * @property string $CreationTime
 */
class Log extends \CActiveRecord
{
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'ApiLog';
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