<?php
namespace event\models;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $UserId
 * @property string $Phone
 * @property string $Company
 * @property string $Position
 * @property string $Info
 * @property string $CreationTime
 * @property int $Approved
 * @property int $ApprovedTime
 *
 * @property \user\models\User $User
 */
class InviteRequest extends \CActiveRecord
{
  /**
   * @param string $className
   * @return Type
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventInviteRequest';
  }

  public function primaryKey()
  {
    return 'Id';
  }
  
  public function relations()
  {
    return array(
      'User' => array(self::BELONGS_TO, '\user\models\User', 'UserId')  
    );
  }
  
  /**
   * 
   * @param int $eventId
   * @param bool $useAnd
   * @return \event\models\Invite
   */
  public function byEventId($eventId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."EventId" = :EventId';
    $criteria->params = array('EventId' => $eventId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
  
  /**
   * 
   * @param int $userId
   * @param bool $useAnd
   * @return \event\models\InviteRequest
   */
  public function byUserId($userId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."UserId" = :UserId';
    $criteria->params = array('UserId' => $userId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}