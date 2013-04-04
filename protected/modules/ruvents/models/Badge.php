<?php
namespace ruvents\models;

/**
 * @property int $Id
 * @property int $OperatorId
 * @property int $EventId
 * @property int $PartId
 * @property int $UserId
 * @property int $RoleId
 * @property string $CreationTime
 *
 * @property \event\models\Role $Role
 * @property \user\models\User $User
 * @property \event\models\Part $Part
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
    return 'RuventsBadge';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Role' => array(self::BELONGS_TO, '\event\models\Role', 'RoleId'),
      'User' => array(self::BELONGS_TO, '\user\models\User', 'UserId'),
      'Part' => array(self::BELONGS_TO, '\event\models\Part', 'PartId')
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
    $criteria->condition = '"t"."UserId" = :UserId';
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
    $criteria->condition = '"t"."EventId" = :EventId';
    $criteria->params = array(':EventId' => $eventId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param int|null $partId
   * @param bool $useAnd
   *
   * @return Badge
   */
  public function byPartId($partId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    if ($partId !== null)
    {
      $criteria->condition = '"t"."PartId" = :PartId';
      $criteria->params = array(':PartId' => $partId);
    }
    else
    {
      $criteria->condition = '"t"."PartId" IS NULL';
    }
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

}