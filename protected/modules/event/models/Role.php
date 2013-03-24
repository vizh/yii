<?php
namespace event\models;

/**
 * @property int $Id
 * @property string $Code
 * @property string $Title
 * @property int $Priority
 */
class Role extends \CActiveRecord
{

  /**
   * @param string $className
   * @return Role
   */
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'EventRole';
  }
  
  public function primaryKey()
  {
    return 'Id';
  }
  
  public function relations()
  {
    return array(
      'Participants' => array(self::HAS_MANY, 'event\models\Participant', 'RoleId')
    );
  }

  public function byEventId($eventId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 'Participants.EventId = :EventId';
    $criteria->params = array('EventId' => $eventId);
    $criteria->with = array('Participants' => array('together' => true, 'select' => false));
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}