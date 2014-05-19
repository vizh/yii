<?php
namespace link\models;
/**
 * Class Link
 * @package link\models
 * @property int $Id
 * @property int $EventId
 * @property int $UserId
 * @property int $OwnerId
 * @property int $Approved
 * @property string $CreationTime
 * @property string $MeetingTime
 * @property \user\models\User $User
 * @property \user\models\User $Owner
 * @property \event\models\Event $Event
 */
class Link extends \CActiveRecord
{
  /**
   * @param string $className
   * @return Link
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'Link';
  }

  public function relations()
  {
    return [
      'User'  => [self::BELONGS_TO,'\user\models\User', 'UserId'],
      'Owner' => [self::BELONGS_TO,'\user\models\User', 'OwnerId'],
      'Event' => [self::BELONGS_TO,'\event\models\Event', 'EventId']
    ];
  }

  public function primaryKey()
  {
    return 'Id';
  }

  /**
   * @param int $eventId
   * @param bool $useAnd
   * @return $this
   */
  public function byEventId($eventId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."EventId" = :EventId';
    $criteria->params = ['EventId' => $eventId];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param int $userId
   * @param bool $useAnd
   * @return $this
   */
  public function byUserId($userId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."UserId" = :UserId';
    $criteria->params = ['UserId' => $userId];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param int $userId
   * @param bool $useAnd
   * @return $this
   */
  public function byAnyUserId($userId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."UserId" = :UserId OR "t"."OwnerId" = :UserId';
    $criteria->params = ['UserId' => $userId];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }


  /**
   * @param int $ownerId
   * @param bool $useAnd
   * @return $this
   */
  public function byOwnerId($ownerId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."OwnerId" = :OwnerId';
    $criteria->params = ['OwnerId' => $ownerId];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param int $approved
   * @param bool $useAnd
   * @return $this
   */
  public function byApproved($approved, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."Approved" = :Approved';
    $criteria->params = ['Approved' => $approved];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  public function getFormattedMeetingTime($pattern = 'dd MMMM yyyy')
  {
    return \Yii::app()->dateFormatter->format($pattern, $this->MeetingTime);
  }

  protected $beforeSaveIsNewRecord = null;
  protected $beforeSaveMeetingTime = null;
  protected $beforeSaveApproved    = null;

  protected function beforeSave()
  {
    $this->beforeSaveIsNewRecord = $this->getIsNewRecord();
    if (!$this->beforeSaveIsNewRecord)
    {
      $link = $this->findByPk($this->Id);
      /** @var  Link $link */
      $this->beforeSaveMeetingTime = $link->MeetingTime;
      $this->beforeSaveApproved = $link->Approved;
    }
    return parent::beforeSave();
  }

  protected function afterSave()
  {
    $eventType = null;
    if ($this->beforeSaveIsNewRecord)
    {
      $eventType = 'create';
    }
    elseif ($this->beforeSaveApproved != \event\models\Approved::Yes && $this->Approved == \event\models\Approved::Yes)
    {
      $eventType = 'approve';
    }
    elseif ($this->beforeSaveMeetingTime !== null && $this->beforeSaveMeetingTime !== $this->MeetingTime)
    {
      $eventType = 'changetime';
    }

    if ($eventType !== null)
    {
      $event  = new \CModelEvent($this);
      $mailer = new \mail\components\mailers\PhpMailer();
      $sender = $event->sender;
      $class  = \Yii::getExistClass('\link\components\handlers\\'.$eventType, ucfirst($sender->Event->IdName), 'Base');
      /** @var \mail\components\Mail $mail */
      $mail = new $class($mailer, $event);
      $mail->send();
    }
    parent::afterSave();
  }
} 