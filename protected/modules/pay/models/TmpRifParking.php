<?php

namespace pay\models;

use application\components\ActiveRecord;

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
 *
 * @method \pay\models\TmpRifParking byEventId()
 */
class TmpRifParking extends ActiveRecord
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