<?php
namespace user\models;

/**
 * Class LinkEventPurpose
 * @package user\models
 * @property int $Id
 * @property int $UserId
 * @property int $EventId
 * @property int $PurposeId
 * @property \event\models\Purpose $Purpose
 * @property User $User
 */
class LinkEventPurpose extends \CActiveRecord
{
  /**
   * @param string $className
   * @return LinkEventPurpose
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'UserLinkEventPurpose';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return [
      'Purpose' => [self::BELONGS_TO, '\event\models\Purpose', 'PurposeId'],
      'User' => [self::BELONGS_TO, '\user\models\User', 'UserId']
    ];
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