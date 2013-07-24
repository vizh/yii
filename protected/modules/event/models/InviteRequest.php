<?php
namespace event\models;

/**
 * @property int $Id
 * @property int $OwnerUserId
 * @property string $CreationTime
 * @property int $EventId
 * @property int $Approved
 * @property int $ApprovedTime
 * @property int $SenderUserId
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
      'Sender' => array(self::BELONGS_TO, '\user\models\User', 'SenderUserId'),
      'Owner'  => array(self::BELONGS_TO, '\user\models\User', 'OwnerUserId'),
      'Event'  => array(self::BELONGS_TO, '\event\models\Event', 'EventId')
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
  public function byOwnerUserId($userId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."OwnerUserId" = :UserId';
    $criteria->params = array('UserId' => $userId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
  
  /**
   * 
   * @param \event\models\Approved $status
   * @param \event\models\Role $role
   * @throws Exception
   */
  public function changeStatus($status, \event\models\Role $role = null)
  {
    if ($status == \event\models\Approved::Yes && $role == null)
      throw new Exception("Не передан обязательный параметр Role");
    
    $this->Approved = $status;
    $this->ApprovedTime = date('Y-m-d H:i:s');
    $this->save();
    
    if ($status == \event\models\Approved::Yes)
    {
      if (empty($this->Event->Parts))
        $this->Event->registerUser($this->Owner, $role);
      else
        $this->Event->registerUserOnAllParts($this->Owner, $role);
    }
  }
}