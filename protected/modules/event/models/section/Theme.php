<?php
namespace event\models\section;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Title
 * @property string $ColorBackground
 * @property string $ColorTitle
 */
class Theme extends \CActiveRecord
{
  /**
   * @param string $className
   *
   * @return Theme
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventSectionTheme';
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