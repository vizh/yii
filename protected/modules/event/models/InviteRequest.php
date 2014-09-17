<?php
namespace event\models;
use mail\components\mailers\MandrillMailer;

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
   * @return InviteRequest
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
   * @return InviteRequest
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
   * @return InviteRequest
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
    elseif ($status == \event\models\Approved::No)
    {
      $event = new \CModelEvent($this, array('event' => $this->Event, 'user' => $this->Owner));
      $this->onDisapprove($event);
    }
  }

  /**
   * @return bool
   */
  protected function beforeSave()
  {
    if ($this->getIsNewRecord())
    {
      $event = new \CModelEvent($this, ['event' => $this->Event, 'user' => $this->Owner]);
      $this->onCreate($event);
    }
    return parent::beforeSave();
  }


  /**
   * @param $event
   */
  public function onCreate($event)
  {
    $mailer = new MandrillMailer();
    $class = \Yii::getExistClass('\event\components\handlers\invite\create', ucfirst($event->params['event']->IdName), 'Base');
    $mail = new $class($mailer, $event);
    $mail->send();
  }

  /**
   * @param \CModelEvent $event
   */
  public function onDisapprove($event)
  {
    $mailer = new MandrillMailer();
    $class = \Yii::getExistClass('\event\components\handlers\invite\disapprove', ucfirst($event->params['event']->IdName), 'Base');
    $mail = new $class($mailer, $event);
    $mail->send();
  }
}