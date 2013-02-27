<?php
namespace event\models\section;

/**
 * @property int $Id
 * @property string $Title
 */
class Type extends \CActiveRecord
{
  /**
   * @param string $className
   *
   * @return Type
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventSectionType';
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