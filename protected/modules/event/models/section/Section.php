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
class Section extends \application\models\translation\ActiveRecord
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
      'Type' => array(self::BELONGS_TO, '\event\models\section\Type', 'TypeId'),
      'Favorites' => array(self::HAS_MANY, '\event\models\section\Favorite', 'SectionId')
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
  
  public function byDate($date, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."StartTime" >= :DateStart AND "t"."EndTime" <= :DateEnd';
    $criteria->params['DateStart'] = $date.' 00:00:00';
    $criteria->params['DateEnd'] = $date.' 23:59:59';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
  
  /**
   * 
   * @param \event\models\section\Hall $hall
   * @return \event\models\section\Section
   */
  public function setHall($hall)
  {
    $linkHall = new \event\models\section\LinkHall();
    $linkHall->HallId = $hall->Id;
    $linkHall->SectionId = $this->Id;
    $linkHall->save();
  }
  
  /**
   * 
   * @param string $name
   * @param string $value
   */
  public function setSectionAttribute($name, $value)
  {
    $attribute = null;
    foreach ($this->Attributes as $attr)
    {
      if ($attr->Name == $name)
      {
        $attribute = $attr;
      }
    }
    if ($attribute == null)
    {
      $attribute = new \event\models\section\Attribute();
      $attribute->Name = $name;
      $attribute->SectionId = $this->Id;
    }
    $attribute->Value = $value;
    $attribute->save();
  }
  
  private $url = null;
  public function getUrl()
  {
    if ($this->url == null
      && isset($this->Event->UrlSectionMask))
    {
      $this->url = str_replace(':SECTION_ID', $this->Id, $this->Event->UrlSectionMask);
    }
    return $this->url;
  }

  public function addToFavorite(\user\models\User $user)
  {
    if (!Favorite::model()->byUserId($user->Id)->bySectionId($this->Id)->exists())
    {
      $favorite = new Favorite();
      $favorite->SectionId = $this->Id;
      $favorite->UserId = $user->Id;
      $favorite->save();
    }
  }

  /**
   * @return \string[]
   */
  public function getTranslationFields()
  {
    return ['Title', 'Info'];
  }
}