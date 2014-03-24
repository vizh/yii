<?php
namespace event\models;

/**
 * Class Purpose
 * @package event\models
 * @property int $Id
 * @property string $Title
 * @property bool $Visible
 */
class Purpose extends \CActiveRecord
{
  /**
   * @param string $className
   * @return Purpose
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventPurpose';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  /**
   * @param bool $visible
   * @param bool $useAnd
   * @return $this
   */
  public function byVisible($visible = true, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = !$visible ? 'NOT ' : ''.'"t"."Visible"';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
} 