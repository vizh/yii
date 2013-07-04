<?php
namespace event\models;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Code
 * @property int $RoleId
 * @property int $UserId
 * @property string $CreationTime
 * @property string $ActivationTime
 *
 * @property \user\models\User $User
 */
class InviteCode extends \CActiveRecord
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
    return 'EventInviteCode';
  }

  public function primaryKey()
  {
    return 'Id';
  }
  
  public function relations()
  {
    return array(
      'User' => array(self::BELONGS_TO, '\user\models\User', 'UserId'),
      'Role' => array(self::BELONGS_TO, '\event\models\Role', 'RoleId')
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
   * @param string $code
   * @param bool $useAnd
   * @return \event\models\InviteCode
   */
  public function byCode($code, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."Code" = :Code';
    $criteria->params = array('Code' => $code);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}