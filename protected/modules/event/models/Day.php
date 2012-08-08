<?php
namespace event\models;

/**
 * @property int $DayId
 * @property int $EventId
 * @property string $Title
 * @property int $Order
 *
 * @property Event $Event
 */
class Day extends \CActiveRecord
{
  /**
   * @static
   * @param string $className
   * @return Day
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventDay';
  }

  public function primaryKey()
  {
    return 'EventDayId';
  }

  public function relations()
  {
    return array(
      'Event' => array(self::BELONGS_TO, 'Event', 'EventId'),
    );
  }
}