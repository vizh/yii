<?php
namespace event\models\section;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Title
 * @property int $Order
 */
class Hall extends \CActiveRecord
{
  /**
   * @param string $className
   *
   * @return Hall
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventSectionHall';
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