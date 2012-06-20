<?php

/**
 * @property int $AccountId
 * @property int $EventId
 * @property string $Login
 * @property string $Password
 * @property string $NoticeEmail
 */
class PartnerAccount extends CActiveRecord
{
  public static $TableName = 'Mod_PartnerAccount';

  /**
   * @static
   * @param string $className
   * @return PartnerAccount
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
    return 'AccountId';
  }

  /**
   * @param int $eventId
   * @param bool $useAnd
   * @return PartnerAccount
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
   * @param string $password
   * @return string
   */
  public function GetHash($password)
  {
    return md5($password);
  }

  /** @var PartnerNotifier */
  protected $notifier = null;

  /**
   * @return null|PartnerNotifier
   */
  public function GetNotifier()
  {
    if (empty($this->notifier))
    {
      $this->notifier = new PartnerNotifier($this);
    }

    return $this->notifier;
  }
}