<?php
namespace event\models\section;


/**
 * @property int $Id
 * @property int $SectionId
 * @property int $UserId
 * @property int $RoleId
 * @property int $ReportId
 * @property int $Order
 *
 * @property Section $Section
 * @property \user\models\User $User
 * @property Role $Role
 * @property Report $Report
 */
class LinkUser extends \CActiveRecord
{
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'EventSectionLinkUser';
  }
  
  public function primaryKey()
  {
    return 'Id';
  }
  
  public function relations()
  {
    return array(
      'Section' => array(self::BELONGS_TO, '\event\models\section\Section', 'SectionId'),
      'User' => array(self::BELONGS_TO, '\user\models\User', 'UserId'),
      'Report' => array(self::BELONGS_TO, '\event\models\section\Report', 'ReportId'),
      'Role' => array(self::BELONGS_TO, '\event\models\section\Role', 'RoleId'),
    );
  }
}