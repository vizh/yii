<?php
namespace pay\models;

/**
 * Class EventUserAdditionalAttribute
 * @package pay\models
 * @property int $Id
 * @property int $EventId
 * @property int $UserId
 * @property string $Name
 * @property string $Value
 *
 * @method \pay\models\EventUserAdditionalAttribute find($condition='',$params=array())
 * @method \pay\models\EventUserAdditionalAttribute findByPk($pk,$condition='',$params=array())
 * @method \pay\models\EventUserAdditionalAttribute[] findAll($condition='',$params=array())
 */
class EventUserAdditionalAttribute extends \CActiveRecord
{
  /**
   * @param string $className
   *
   * @return EventUserAdditionalAttribute
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventUserAdditionalAttribute';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  /**
   * @param int $eventId
   * @param bool $useAnd
   * @return $this
   */
  public function byEventId($eventId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."EventId" = :EventId';
    $criteria->params = ['EventId' => $eventId];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param int $userId
   * @param bool $useAnd
   * @return $this
   */
  public function byUserId($userId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."UserId" = :UserId';
    $criteria->params = ['UserId' => $userId];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param string $name
   * @param bool $useAnd
   * @return $this
   */
  public function byName($name, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."Name" = :Name';
    $criteria->params = ['Name' => $name];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
} 