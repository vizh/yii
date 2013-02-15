<?php
namespace partner\models;

/**
 * @property int $AccountId
 * @property int $EventId
 * @property string $Login
 * @property string $Password
 * @property string $NoticeEmail
 * @property string $Role
 */
class Account extends \CActiveRecord
{
  /**
   * @static
   * @param string $className
   * @return Account
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'PartnerAccount';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  /**
   * @param int $eventId
   * @param bool $useAnd
   * @return Account
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
   * @param string $password
   * @return string
   */
  public function getHash($password)
  {
    return md5($password);
  }

  /** @var \partner\components\Notifier */
  protected $notifier = null;

  /**
   * @return null|\partner\components\Notifier
   */
  public function getNotifier()
  {
    if (empty($this->notifier))
    {
      $this->notifier = new \partner\components\Notifier($this);
    }

    return $this->notifier;
  }
}