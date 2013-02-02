<?php
namespace oauth\models;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $EventId
 * @property string $CreationTime
 * @property bool $Verified
 * @property bool $Deleted
 * @property string $DeletionTime
 */
class Permission extends \CActiveRecord
{
  /**
   * @param string $className
   * @return Permission
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'OAuthPermission';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(

    );
  }

  /**
   * @param int $userId
   * @param bool $useAnd
   * @return Permission
   */
  public function byUserId($userId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."UserId" = :UserId';
    $criteria->params = array(':UserId' => $userId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param int $eventId
   * @param bool $useAnd
   * @return Permission
   */
  public function byEventId($eventId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."EventId" = :EventId';
    $criteria->params = array(':EventId' => $eventId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param bool $deleted
   * @param bool $useAnd
   * @return Permission
   */
  public function byDeleted($deleted, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = ($deleted ? '' : 'NOT ') . '"t"."Deleted"';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}
