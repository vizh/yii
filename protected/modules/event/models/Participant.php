<?php
namespace event\models;
/*AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('partner.source.*');*/

/**
 * @property int $EventUserId
 * @property int $EventId
 * @property int $DayId
 * @property int $UserId
 * @property int $RoleId
 * @property int $Approve
 * @property int $CreationTime
 * @property int $UpdateTime
 *
 * @property \user\models\User $User
 * @property Role $Role
 * @property Event $Event
 * @property Day $Day
 */
class Participant extends \CActiveRecord
{
  public static $TableName = 'EventUser';

  /**
   * @static
   * @param string $className
   * @return Participant
   */
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return self::$TableName;
  }
  
  public function primaryKey()
  {
    return 'EventUserId';
  }
  
  public function relations()
  {
    return array(
      'Event' => array(self::BELONGS_TO, 'Event', 'EventId', 'order' => 'Event.DateStart DESC, Event.DateEnd DESC'),
      'Role' => array(self::BELONGS_TO, '\event\models\Role', 'RoleId'),
      'User' => array(self::BELONGS_TO, 'User', 'UserId'),
      'Day' => array(self::BELONGS_TO, 'EventDay', 'DayId')
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
    $criteria->condition = 't.UserId = :UserId';
    $criteria->params = array(':UserId' => $userId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  public function byEventId($eventId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.EventId = :EventId';
    $criteria->params = array(':EventId' => $eventId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  public function byDayId($dayId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.DayId = :DayId';
    $criteria->params = array(':DayId' => $dayId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  public function byDayNull($useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.DayId IS NULL';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @static
   * @param int $userId
   * @param int $eventId
   * @return Participant
   */
  public static function GetByUserEventId($userId, $eventId)
  {
    $eventUser = Participant::model();

    $criteria = new \CDbCriteria();
    $criteria->condition = 't.UserId = :UserId AND t.EventId = :EventId';
    $criteria->params = array(':UserId' => $userId, ':EventId' => $eventId);
    return $eventUser->find($criteria);
  }

  /**
   * Возвращает EventUser сгруппированные по RoleId
   * @static
   * @param $eventId
   * @return Participant[]
   */
  public static function GetEventRoles($eventId)
  {
    $eventUser = Participant::model()->with('EventRole')->together();

    $criteria = new \CDbCriteria();
    $criteria->condition = 't.EventId = :EventId';
    $criteria->params = array(':EventId' => $eventId);
    $criteria->group = 't.RoleId';
    $criteria->order = 'EventRole.Priority DESC';
    return $eventUser->findAll($criteria);
  }

  /**
   * @static
   * @return int
   */
  public static function AllCount()
  {
    return Participant::model()->count();
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