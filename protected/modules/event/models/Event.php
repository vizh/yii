<?php
namespace event\models;

use tag\models\ITaggable;

/**
 * @property int $Id
 * @property string $IdName
 * @property string $Title
 * @property string $Info
 * @property string $FullInfo
 * @property int $StartYear
 * @property int $StartMonth
 * @property int $StartDay
 * @property int $EndYear
 * @property int $EndMonth
 * @property int $EndDay
 * @property bool $Visible
 * @property bool $ShowOnMain
 *
 *
 * @property Part[] $Parts
 * @property \event\models\section\Section[] $Sections
 * @property LinkAddress $LinkAddress
 * @property LinkPhone[] $LinkPhones
 * @property LinkEmail[] $LinkEmails
 * @property LinkSite $LinkSite
 * @property Type $Type
 *
 * @property Widget[] $Widgets
 * @property Attribute[] $Attributes
 * @property Partner[] $Partners
 *
 * @property LinkTag[] $LinkTags
 *
 *
 * Attribute properties
 *
 * @property string $UrlSectionMask
 */
class Event extends \application\models\translation\ActiveRecord implements ITaggable
{
  /**
   * @param string $className
   * @return Event
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'Event';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Parts' => array(self::HAS_MANY, '\event\models\Part', 'EventId'),
      'Participants' => array(self::HAS_MANY, '\event\models\Participant', 'EventId', 'with' => array('Role')),

      'Type' => array(self::BELONGS_TO, '\event\models\Type', 'TypeId'),

      'LinkAddress' => array(self::HAS_ONE, '\event\models\LinkAddress', 'EventId'),
      'LinkPhones' => array(self::HAS_MANY, '\event\models\LinkPhone', 'EventId'),
      'LinkEmails' => array(self::HAS_MANY, '\event\models\LinkEmail', 'EventId'),
      'LinkSite' => array(self::HAS_ONE, '\event\models\LinkSite', 'EventId'),
      'Sections' => array(self::HAS_MANY, '\event\models\section\Section', 'EventId', 'order' => 'Sections.DatetimeStart ASC, Sections.DatetimeFinish ASC, Sections.Place ASC'),


      'Widgets' => array(self::HAS_MANY, '\event\models\Widget', 'EventId', 'order' => '"Widgets"."Order" ASC'),
      'Attributes' => array(self::HAS_MANY, '\event\models\Attribute', 'EventId'),

      'Partners' => array(self::HAS_MANY, '\event\models\Partner', 'EventId'),

      'LinkTags' => array(self::HAS_MANY, '\event\models\LinkTag', 'EventId', 'with' => 'Tag')
    );
  }

  /**
   * @return string[]
   */
  public function getTranslationFields()
  {
    return array('Title', 'Info', 'FullInfo', 'Place');
  }

  /**
   * @return string[]
   */
  protected function getInternalAttributeNames()
  {
    return array('UrlSectionMask');
  }

  public function __get($name)
  {
    if (in_array($name, $this->getInternalAttributeNames()))
    {
      $attribute = $this->getAttribute($name);
      if (is_array($attribute))
      {
        throw new \application\components\Exception('Работа с массивами в компоненте еще не реализована. Обращение к полю ' . $name);
      }
      elseif ($attribute === null)
      {
        throw new \application\components\Exception('У мероприятия не задан аттрибут ' . $name);
      }
      else
      {
        return $attribute->Value;
      }
    }
    else
    {
      return parent::__get($name);
    }
  }

  public function __set($name, $value)
  {
    parent::__set($name, $value);
  }

  public function __isset($name)
  {
    if (in_array($name, $this->getInternalAttributeNames()))
    {
      $attribute = $this->getAttribute($name);
      return $attribute !== null;
    }
    return parent::__isset($name);
  }


  /**
   * @param string $idName
   * @param bool $useAnd
   * @return Event
   */
  public function byIdName($idName, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."IdName" = :IdName';
    $criteria->params = array('IdName' => $idName);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  public function byType($typeId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."TypeId" = :TypeId';
    $criteria->params = array('TypeId' => $typeId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  public function bySearch($searchTerm, $locale = null, $useAnd = true)
  {
    $criteria = new \CDbCriteria();

    $searchTerm = trim($searchTerm);
    if (empty($searchTerm))
    {
      $criteria->addCondition('0=1');
      $this->getDbCriteria()->mergeWith($criteria, $useAnd);
      return $this;
    }
    $criteria->addCondition('"t"."Title" LIKE :SearchTerm');
    $criteria->params['SearchTerm'] = '%' . \Utils::PrepareStringForLike($searchTerm) . '%';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  public function byVisible($visible = true, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = ($visible ? '' : 'NOT ') . '"t"."Visible"';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  public function byShowOnMain($showOnMain = true, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = ($showOnMain ? '' : 'NOT ') . '"t"."ShowOnMain"';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  public function byDate($year, $month = null, $useAnd = true)
  {
    $criteriaStart = new \CDbCriteria();
    $criteriaEnd = new \CDbCriteria();
    $criteriaStart->addCondition('"t"."StartYear" = :Year');
    $criteriaEnd->addCondition('"t"."EndYear" = :Year');
    $params = array('Year' => $year);
    if ($month !== null)
    {
      $criteriaStart->addCondition('"t"."StartMonth" = :Month');
      $criteriaEnd->addCondition('"t"."EndMonth" = :Month');
      $params['Month'] = $month;
    }
    $criteriaStart->mergeWith($criteriaEnd, 'OR');
    $criteriaStart->params = $params;
    $this->getDbCriteria()->mergeWith($criteriaStart, $useAnd);
    return $this;
  }

  public function byFromDate($year, $month = 1, $day = 1, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."EndYear" > :FromYear OR ("t"."EndYear" = :FromYear AND "t"."EndMonth" > :FromMonth) OR ("t"."EndYear" = :FromYear AND "t"."EndMonth" = :FromMonth AND "t"."EndDay" >= :FromDay)';
    $criteria->params = array(
      'FromYear' => $year,
      'FromMonth' => $month,
      'FromDay' => $day
    );
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  public function byToDate($year, $month = 12, $day = 31, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."StartYear" < :ToYear OR ("t"."StartYear" = :ToYear AND "t"."StartMonth" < :ToMonth) OR ("t"."StartYear" = :ToYear AND "t"."StartMonth" = :ToMonth AND "t"."StartDay" <= :ToDay)';
    $criteria->params = array(
      'ToYear' => $year,
      'ToMonth' => $month,
      'ToDay' => $day
    );
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param int $id
   * @param bool $useAnd
   *
   * @return Event
   */
  public function byTagId($id, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"LinkTags"."TagId" = :TagId';
    $criteria->params = array('TagId' => $id);
    $criteria->with = array('LinkTags' => array('together' => true));
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }


  public function registerUser(\user\models\User $user, Role $role, $usePriority = false)
  {
    if (!empty($this->Parts))
    {
      throw new \application\components\Exception('Данное мероприятие имеет логическую разбивку. Используйте метод регистрации на конкретную часть мероприятия.');
    }
    /** @var $participant Participant */
    $participant = Participant::model()
        ->byEventId($this->EventId)
        ->byUserId($user->UserId)
        ->byPartId(null)->find();
    if (empty($participant))
    {
      $participant = $this->registerUserUnsafe($user, $role);
    }
    else
    {
      $this->updateRole($participant, $role, $usePriority);
    }
    return $participant;
  }

  public function registerUserOnPart(Part $part, \user\models\User $user, Role $role, $usePriority = false)
  {
    if (empty($this->Parts))
    {
      throw new \application\components\Exception('Данное мероприятие не имеет логической разбивки. Используйте метод регистрации на все мероприятие.');
    }
    /** @var $participant Participant */
    $participant = Participant::model()
        ->byEventId($this->EventId)
        ->byUserId($user->UserId)
        ->byPartId($part->Id)->find();
    if (empty($participant))
    {
      $participant = $this->registerUserUnsafe($user, $role, $part);
    }
    else
    {
      $this->updateRole($participant, $role, $usePriority);
    }
    return $participant;
  }

  private function registerUserUnsafe(\user\models\User $user, Role $role, Part $part = null)
  {
    $participant = new Participant();
    $participant->EventId = $this->EventId;
    $participant->PartId = ($part != null) ? $part->Id : null;
    $participant->UserId = $user->UserId;
    $participant->RoleId = $role->RoleId;
    $participant->save();

    return $participant;
  }

  private function updateRole(Participant $participant, Role $role, $usePriority = false)
  {
    if (!$usePriority || $participant->Role->Priority <= $role->Priority)
    {
      $participant->RoleId = $role->RoleId;
      $participant->UpdateTime =  date('Y-m-d H:i:s');
      $participant->save();
      return true;
    }
    return false;
  }

  public function registerUserOnAllDays(\user\models\User $user, Role $role)
  {
    $result = array();
    foreach ($this->Days as $day)
    {
      $result[$day->DayId] = $this->registerUserOnPart($day, $user, $role);
    }
    return $result;
  }

  /**
   * @return \contact\models\Address|null
   */
  public function getContactAddress()
  {
    return !empty($this->LinkAddress) ? $this->LinkAddress->Address : null;
  }

  /**
   * @return \contact\models\Site|null
   */
  public function getContactSite()
  {
    return !empty($this->LinkSite) ? $this->LinkSite->Site : null;
  }

  /**
   * @return Role[]
   */
  public function getUsingRoles()
  {
    $criteria = new \CDbCriteria();
    $criteria->group = 't.RoleId';
    $criteria->with = array('Role');

    /** @var $participants Participant[] */
    $participants = Participant::model()->byEventId($this->Id)->findAll($criteria);
    $result = array();
    foreach ($participants as $participant)
    {
      $result[] = $participant->Role;
    }
    return $result;
  }

  public function getParticipantsCount()
  {
    $criteria = new \CDbCriteria();
    $criteria->addCondition('User.Visible = :Visible');
    $criteria->params['Visible'] = true;
    $criteria->with = array('User');
    $criteria->group = 't.UserId';

    return Participant::model()->byEventId($this->Id)->count($criteria);
  }

  /** @var Logo */
  private $logo = null;
  /**
   * @return Logo
   */
  public function getLogo()
  {
    if ($this->logo === null)
    {
      $this->logo = new Logo($this->IdName);
    }
    return $this->logo;
  }

  /**
   * @param string $name
   * @return Attribute|Attribute[]|null
   */
  public function getAttribute($name)
  {
    $attributes = $this->getAttributesByName();
    return isset($attributes[$name]) ? $attributes[$name] : null;
  }

  private $attributesByName = null;
  /**
   * @return array
   */
  private function getAttributesByName()
  {
    if ($this->attributesByName === null)
    {
      $this->attributesByName = array();
      foreach ($this->Attributes as $attribute)
      {
        if (!isset($this->attributesByName[$attribute->Name]))
        {
          $this->attributesByName[$attribute->Name] = $attribute;
        }
        else
        {
          if (!is_array($this->attributesByName[$attribute->Name]))
          {
            $this->attributesByName[$attribute->Name] = array($this->attributesByName[$attribute->Name]);
          }
          $this->attributesByName[$attribute->Name][] = $attribute;
        }
      }
    }

    return $this->attributesByName;
  }
}