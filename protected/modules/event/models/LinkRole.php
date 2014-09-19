<?php
namespace event\models;

/**
 * Class LinkRole
 * @property int $Id
 * @property int $EventId
 * @property int $RoleId
 * @property string $Color
 * @package event\models
 */
class LinkRole extends \CActiveRecord
{
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventLinkRole';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return [
      'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
      'Role' => [self::BELONGS_TO, '\event\models\Role', 'RoleId']
    ];
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
   * @param int $roleId
   * @param bool $useAnd
   * @return $this
   */
  public function byRoleId($roleId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."RoleId" = :RoleId';
    $criteria->params = ['RoleId' => $roleId];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
} 