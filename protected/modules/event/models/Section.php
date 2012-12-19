<?php
namespace event\models;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Type
 * @property string $Abbr
 * @property string $Title
 * @property string $Comment
 * @property string $Audience
 * @property string $Rubricator
 * @property string $LinkPhoto
 * @property string $LinkVideo
 * @property string $LinkShorthand
 * @property string $LinkAudio
 * @property string $DatetimeStart
 * @property string $DatetimeFinish
 * @property string $Place
 * @property string $Description
 * @property string $Partners
 * @property int $Fill
 * @property string $Access
 * @property string $UpdateTime
 *
 * @property SectionUserLink[] $UserLinks
 * @property Event $Event
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
      'Event' => array(self::BELONGS_TO, 'Event', 'EventId'),
      'UserLinks' => array(self::HAS_MANY, 'SectionUserLink', 'EventProgramId', 'order' => 'UserLinks.Order ASC'),
    );
  }
  
  /**
  * @return Section
  */
  public static function GetEventProgramById($id, $onlyHereUsers = false)
  {
    $eventProgram = null;
    if (! $onlyHereUsers)
    {
      $eventProgram = Section::model()->with('UserHereList', 'UserLinks.User', 'UserLinks.Report', 'UserLinks.Role')->together();
    }
    else
    {
      $eventProgram = Section::model()->with('UserHereList.User')->together();
    }
    
    return $eventProgram->findByPk($id);   
  }
  
  /**
  * @return Event
  */
  public function GetEvent()
  {
    return $this->Event;
  }
  
  /**
  * @return array[EventProgramUserLink]
  */
  public function GetUserLinks()
  {
    return $this->UserLinks;
  }
}
