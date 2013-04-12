<?php
namespace pay\models;

/**
 * @property int $Id
 * @property int $EventId
 * @property bool $Own
 * @property string $OrderTemplateName
 * @property string $ReturnUrl
 * @property string $Offer
 * @property string $OrderLastTime
 *
 * @property \event\models\Event $Event
 */
class Account extends \CActiveRecord
{
  /**
   * @param string $className
   *
   * @return Account
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'PayAccount';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Event' => array(self::BELONGS_TO, '\event\models\Event', 'EventId')
    );
  }

  /**
   * @param int $eventId
   * @param bool $useAnd
   *
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
}
