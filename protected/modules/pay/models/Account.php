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
 * @property bool $OrderEnable
 * @property bool $Uniteller
 * @property bool $PayOnline
 * @property int  $OrderTemplateId
 * @property bool $SandBoxUser
 * @property string $SandBoxUserRegisterUrl
 * @property string $ReceiptName
 * @property int $ReceiptId
 * @property string $ReceiptLastTime
 * @property bool $ReceiptEnable
 *
 * @property \event\models\Event $Event
 * @property OrderJuridicalTemplate $OrderTemplate
 * @property OrderJuridicalTemplate $ReceiptTemplate
 *
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
      'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
      'OrderTemplate' => [self::BELONGS_TO, '\pay\models\OrderJuridicalTemplate', 'OrderTemplateId'],
      'ReceiptTemplate' => [self::BELONGS_TO, '\pay\models\OrderJuridicalTemplate', 'ReceiptId'],
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
