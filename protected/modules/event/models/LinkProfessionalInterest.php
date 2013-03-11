<?php
namespace event\models;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $ProfessionalInterestId
 *
 * @property Event $Event
 * @property \application\models\ProfessionalInterest $ProfessionalInterest
 */
class LinkProfessionalInterest extends \CActiveRecord
{
  /**
   * @param string $className
   * @return LinkProfessionalInterest
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventLinkProfessionalInterest';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Event' => array(self::BELONGS_TO, '\event\models\Event', 'EventId'),
      'ProfessionalInterest' => array(self::BELONGS_TO, '\application\models\ProfessionalInterest', 'ProfessionalInterestId'),
    );
  }
  
  /**
   * 
   * @param int $interestId
   * @param bool $useAnd
   * @return \event\models\LinkProfessionalInterest
   */
  public function byInteresId($interestId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."ProfessionalInterestId" = :ProfessionalInterestId';
    $criteria->params = array('ProfessionalInterestId' => $interestId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
  
  /**
   * 
   * @param int $eventId
   * @param bool $useAnd
   * @return \event\models\Widget
   */
  public function byEventId($eventId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."EventId" = :EventId';
    $criteria->params = array('EventId' => $eventId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}
