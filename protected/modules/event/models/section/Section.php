<?php
namespace event\models\section;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Title
 *
 * @property LinkUser[] $LinkUsers
 * @property \event\models\Event $Event
 */
class Section extends \CActiveRecord
{
  /**
   * @param string $className
   * @return Section
   */
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'EventSection';
  }
  
  public function primaryKey()
  {
    return 'Id';
  }
  
  public function relations()
  {
    return array(
      'Event' => array(self::BELONGS_TO, '\event\models\Event', 'EventId'),
      'LinkUsers' => array(self::HAS_MANY, '\event\models\section\LinkUser', 'SectionId', 'order' => 'LinkUsers.Order ASC'),
    );
  }
}