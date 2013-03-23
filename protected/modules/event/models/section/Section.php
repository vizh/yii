<?php
namespace event\models\section;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Title
 * @property string $Info
 * @property string $StartTime
 * @property string $EndTime
 * @property string $UpdateTime
 * @property int $TypeId
 * @property string $Code
 *
 *
 * @property \event\models\Event $Event
 * @property Attribute[] $Attributes
 * @property LinkUser[] $LinkUsers
 * @property LinkHall[] $LinkHalls
 * @property LinkTheme $LinkTheme
 * @property Type $Type
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
      'Attributes' => array(self::HAS_MANY, '\event\models\section\Attribute', 'SectionId'),
      'LinkUsers' => array(self::HAS_MANY, '\event\models\section\LinkUser', 'SectionId', 'order' => '"LinkUsers"."Order" ASC'),
      'LinkHalls' => array(self::HAS_MANY, '\event\models\section\LinkHall', 'SectionId', 'with' => array('Hall'), 'order' => '"Hall"."Order" ASC'),
      'LinkTheme' => array(self::HAS_ONE, '\event\models\section\LinkTheme', 'SectionId'),
      'Type' => array(self::BELONGS_TO, '\event\models\section\Type', 'TypeId')
    );
  }

  public function byEventId($eventId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."EventId" = :EventId';
    $criteria->params = array('EventId' => $eventId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}