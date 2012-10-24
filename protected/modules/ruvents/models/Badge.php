<?php
namespace ruvents\models;

/**
 * @property int $BadgeId
 * @property int $OperatorId
 * @property int $EventId
 * @property int $DayId
 * @property int $UserId
 * @property int $RoleId
 * @property string $CreationTime
 *
 * @property \event\models\Role $Role
 * @property \user\models\User $User
 * @property \event\models\Day $Day
 */
class Badge extends \CActiveRecord
{
  public $CountForCriteria = null;
  public $DateForCriteria = null;
  
  /**
   * @static
   * @param string $className
   * @return Badge
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'Mod_RuventsBadge';
  }

  public function primaryKey()
  {
    return 'BadgeId';
  }

  public function relations()
  {
    return array(
      'Role' => array(self::BELONGS_TO, '\event\models\Role', 'RoleId'),
      'User' => array(self::BELONGS_TO, '\user\models\User', 'UserId'),
      'Day' => array(self::BELONGS_TO, '\event\models\Day', 'DayId')
    );
  }

  /**
   * @param int $userId
   * @param bool $useAnd
   * @return Badge
   */
  public function byUserId($userId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.UserId = :UserId';
    $criteria->params = array(':UserId' => $userId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param $eventId
   * @param bool $useAnd
   * @return Badge
   */
  public function byEventId($eventId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.EventId = :EventId';
    $criteria->params = array(':EventId' => $eventId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param int|null $dayId
   * @param bool $useAnd
   * @return Badge
   */
  public function byDayId($dayId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    if ($dayId !== null)
    {
      $criteria->condition = 't.DayId = :DayId';
      $criteria->params = array(':DayId' => $dayId);
    }
    else
    {
      $criteria->condition = 't.DayId IS NULL';
    }
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param bool $useAnd
   * @return Badge
   */
  public function byDayNull($useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.DayId IS NULL';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}
