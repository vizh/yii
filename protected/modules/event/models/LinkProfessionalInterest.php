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
}
