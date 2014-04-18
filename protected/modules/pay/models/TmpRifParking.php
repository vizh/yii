<?php
namespace pay\models;

/**
 * Class TmpRifParking
 * @package pay\models
 * @property int $Id
 * @property string $Brand
 * @property string $Model
 * @property string $Number
 * @property string $Hotel
 * @property string $DateIn
 * @property string $DateOut
 * @property string $Status
 */
class TmpRifParking extends \CActiveRecord
{
  /**
   * @param string $className
   * @return TmpRifParking
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'TmpRifParking';
  }

  public function primaryKey()
  {
    return 'Id';
  }
} 