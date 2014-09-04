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
 *
 * @method Invite find($condition='',$params=array())
 * @method Invite findByPk($pk,$condition='',$params=array())
 * @method Invite[] findAll($condition='',$params=array())
 */

class Invite extends \CActiveRecord
{
  /**
   * @param string $className
   * @return Invite
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventInvite';
  }

  public function primaryKey()
  {
    return 'Id';
  }
  
  public function relations()
  {
    return array(
      'User'  => array(self::BELONGS_TO, '\user\models\User', 'UserId'),
      'Role'  => array(self::BELONGS_TO, '\event\models\Role', 'RoleId'),
      'Event' => array(self::BELONGS_TO, '\event\models\Event', 'EventId')
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
   * @return Invite
   */
  public function byCode($code, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."Code" = :Code';
    $criteria->params = array('Code' => $code);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
  
  /**
   * 
   * @param \user\models\User $user
   */
  public function activate(\user\models\User $user)
  {
    if ($this->UserId !== null)
      throw new \Exception(\Yii::t('app', 'Приглашение уже активировано'));
    
    $this->UserId = $user->Id;
    $this->ActivationTime = date('Y-m-d H:i:s');
    $this->save();
    
    if (empty($this->Event->Parts))
      $this->Event->registerUser($this->User, $this->Role);
    else
      $this->Event->registerUserOnAllParts($this->User, $this->Role);
  }
}