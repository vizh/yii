<?php
namespace event\models;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Title
 * @property int $Order
 * @property Event $Event
 * @method \event\models\Part findByPk()
 */
class Part extends \CActiveRecord
{
  /**
   * @param string $className
   * @return Part
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventPart';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Event' => array(self::BELONGS_TO, '\event\models\Event', 'EventId'),
    );
  }
}