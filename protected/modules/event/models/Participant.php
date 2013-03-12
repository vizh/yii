<?php
namespace event\models;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $PartId
 * @property int $UserId
 * @property int $RoleId
 * @property string $CreationTime
 * @property string $UpdateTime
 *
 * @property \user\models\User $User
 * @property Role $Role
 * @property Event $Event
 * @property Part $Part
 */
class Participant extends \CActiveRecord
{
  /**
   * @param string $className
   * @return Participant
   */
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'EventParticipant';
  }
  
  public function primaryKey()
  {
    return 'Id';
  }
  
  public function relations()
  {
    return array(
      'Event' => array(self::BELONGS_TO, '\event\models\Event', 'EventId'),
      'Role' => array(self::BELONGS_TO, '\event\models\Role', 'RoleId'),
      'User' => array(self::BELONGS_TO, '\user\models\User', 'UserId'),
      'Part' => array(self::BELONGS_TO, '\event\models\Part', 'PartId')
    );
  }

  /**
   * @param int $userId
   * @param bool $useAnd
   * @return Participant
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
   * @return Participant
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
   * @param int|null $partId
   * @param bool $useAnd
   * @return Participant
   */
  public function byPartId($partId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    if ($partId === null)
    {
      $criteria->addCondition('"t"."PartId" IS NULL');
    }
    else
    {
      $criteria->condition = '"t"."PartId" = :PartId';
      $criteria->params = array('PartId' => $partId);
    }
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param $role Role
   * @param bool $usePriority
   * @return bool
   */
  public function UpdateRole($role, $usePriority = false)
  {
    if (!$usePriority || $this->Role->Priority <= $role->Priority)
    {
      $oldRole = $this->Role;

      $this->RoleId = $role->RoleId;
      $this->UpdateTime = time();
      $this->save();

      /** @var $partnerAccount \partner\models\Account */
      $partnerAccount = \partner\models\Account::model()->byEventId($this->EventId)->find();
      if (!empty($partnerAccount))
      {
        $partnerAccount->GetNotifier()->NotifyRoleChange($this->User, $oldRole, $role);
      }

      return true;
    }

    return false;
  }
}