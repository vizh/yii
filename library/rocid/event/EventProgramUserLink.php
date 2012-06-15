<?php

/**
 * @property int $LinkId
 * @property int $EventId
 * @property int $EventProgramId
 * @property int $UserId
 * @property int $RoleId
 * @property int $ReportId
 * @property int $Order
 *
 * @property User $User
 * @property EventProgramRoles $Role
 * @property EventReports $Report
 * @property EventProgram $EventProgram
 */
class EventProgramUserLink extends CActiveRecord
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
      'EventProgram' => array(self::BELONGS_TO, 'EventProgram', 'EventProgramId'),      
      'User' => array(self::BELONGS_TO, 'User', 'UserId'),
      'Report' => array(self::BELONGS_TO, 'EventReports', 'ReportId'),
      'Role' => array(self::BELONGS_TO, 'EventProgramRoles', 'RoleId'),
    );
  }

  /**
   * @static
   * @param int $id
   * @return EventProgramUserLink
   */
  public static function GetById($id)
  {
    $model = EventProgramUserLink::model();
    return $model->findByPk($id);
  }
  
  /**
  * @return Event
  */
  public function GetEvent()
  {
    return $this->Event;
  }
  
  /**
  * @return User
  */
  public function GetUser()
  {
    return $this->User;
  }
  
  /**
  * @return EventReports
  */
  public function GetReport()
  {
    return $this->Report;
  }
  
  /**
  * @return EventRoles
  */
  public function GetRole()
  {
    return $this->Role;
  }
}
