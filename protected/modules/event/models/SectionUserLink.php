<?php
namespace event\models;


/**
 * @property int $LinkId
 * @property int $EventId
 * @property int $EventProgramId
 * @property int $UserId
 * @property int $RoleId
 * @property int $ReportId
 * @property int $Order
 *
 * @property Event $Event
 * @property \user\models\User $User
 * @property SectionRole $Role
 * @property Report $Report
 * @property Section $Section
 */
class SectionUserLink extends \CActiveRecord
{
  public static $TableName = 'EventProgramUserLink';
  
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return self::$TableName;
  }
  
  public function primaryKey()
  {
    return 'LinkId';
  }
  
  public function relations()
  {
    return array(
      'Event' => array(self::BELONGS_TO, 'Event', 'EventId'),
      'Section' => array(self::BELONGS_TO, 'Section', 'EventProgramId'),
      'User' => array(self::BELONGS_TO, 'User', 'UserId'),
      'Report' => array(self::BELONGS_TO, 'Report', 'ReportId'),
      'Role' => array(self::BELONGS_TO, 'SectionRole', 'RoleId'),
    );
  }

  /**
   * @static
   * @param int $id
   * @return SectionUserLink
   */
  public static function GetById($id)
  {
    $model = SectionUserLink::model();
    return $model->findByPk($id);
  }
  
  /**
  * @return Event
  */
  public function GetEvent()
  {
    return $this->Event;
  }
}