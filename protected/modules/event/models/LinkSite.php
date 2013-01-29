<?php
namespace event\models;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $SiteId
 *
 * @property Event $Event
 * @property \contact\models\Site $Site
 */
class LinkSite extends \CActiveRecord
{
  /**
   * @param string $className
   * @return LinkSite
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventLinkSite';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Event' => array(self::BELONGS_TO, '\event\models\Event', 'EventId'),
      'Site' => array(self::BELONGS_TO, '\contact\models\Site', 'SiteId'),
    );
  }
}
