<?php
namespace event\models\section;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Title
 * @property string $UpdateTime
 * @property int $Order
 */
class Hall extends \application\models\translation\ActiveRecord
{
  /**
   * @param string $className
   *
   * @return Hall
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventSectionHall';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array();
  }
  
  public function byEventId($eventId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."EventId" = :EventId';
    $criteria->params = array('EventId' => $eventId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @return \string[]
   */
  public function getTranslationFields()
  {
    return ['Title'];
  }
}