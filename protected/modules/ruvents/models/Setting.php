<?php
namespace ruvents\models;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Name
 * @property string $Value
 * @method \ruvents\models\Setting find()
 */
class Setting extends \CActiveRecord
{
  /**
   * @param string $className
   *
   * @return Setting
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'RuventsSetting';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function byEventId ($eventId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."EventId" = :EventId';
    $criteria->params = array('EventId' => $eventId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  public function byName($name, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."Name" = :Name';
    $criteria->params = array('Name' => $name);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}