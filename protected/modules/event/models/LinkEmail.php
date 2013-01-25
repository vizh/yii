<?php
namespace event\models;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $EmailId
 *
 * @property Event $Event
 * @property \contact\models\Email $Email
 */
class LinkEmail extends \CActiveRecord
{
  /**
   * @param string $className
   * @return LinkEmail
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventLinkEmail';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Event' => array(self::BELONGS_TO, '\event\models\Event', 'EventId'),
      'Email' => array(self::BELONGS_TO, '\contact\models\Email', 'EmailId'),
    );
  }
}
