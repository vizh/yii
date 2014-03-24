<?php
namespace event\models;

/**
 * Class LinkPurpose
 * @package event\models
 * @property int $Id
 * @property int $EventId
 * @property int $PurposeId
 * @property Purpose $Purpose
 * @property Event $Event
 */
class LinkPurpose extends \CActiveRecord
{
  /**
   * @param string $className
   * @return LinkPurpose
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventLinkPurpose';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return [
      'Purpose' => [self::BELONGS_TO, '\event\models\Purpose', 'PurposeId'],
      'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId']
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
   * @param int $purposeId
   * @param bool $useAnd
   * @return $this
   */
  public function byPurposeId($purposeId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."PurposeId" = :PurposeId';
    $criteria->params = ['PurposeId' => $purposeId];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
} 