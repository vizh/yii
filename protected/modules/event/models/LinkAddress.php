<?php
namespace event\models;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $AddressId
 *
 * @property Event $Event
 * @property \contact\models\Address $Address
 */
class LinkAddress extends \CActiveRecord
{
  /**
   * @param string $className
   * @return LinkAddress
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventLinkAddress';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Event' => array(self::BELONGS_TO, '\event\models\Event', 'EventId'),
      'Address' => array(self::BELONGS_TO, '\contact\models\Address', 'AddressId'),
    );
  }
}
