<?php
namespace event\models;

/**
 * @property int $Id
 * @property string $Code
 * @property string $Title
 * @property string $CssClass
 * @property int $Priority
 *
 */
class Type extends \CActiveRecord
{
  /**
   * @param string $className
   * @return Type
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventType';
  }

  public function primaryKey()
  {
    return 'Id';
  }
}