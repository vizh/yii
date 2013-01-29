<?php
namespace event\models;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $PhoneId
 *
 * @property Event $Event
 * @property \contact\models\Phone $Phone
 */
class LinkPhone extends \CActiveRecord
{
  /**
   * @param string $className
   * @return LinkPhone
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventLinkPhone';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Event' => array(self::BELONGS_TO, '\event\models\Event', 'EventId'),
      'Phone' => array(self::BELONGS_TO, '\contact\models\Phone', 'PhoneId'),
    );
  }
}
