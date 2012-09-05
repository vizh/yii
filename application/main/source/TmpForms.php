<?php

/**
 * @property int $ValueId
 * @property string $FormId
 * @property string $Value
 */
class TmpForms extends CActiveRecord
{
  /**
   * @param string $className
   * @return TmpForms
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'Tmp_Forms';
  }

  public function primaryKey()
  {
    return 'ValueId';
  }

  public function relations()
  {
    return array();
  }
}