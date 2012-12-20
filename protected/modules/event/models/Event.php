<?php
namespace event\models;

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
 *
 *
 * @property Part[] $Parts
 * @property Section[] $Sections
 * @property LinkAddress $LinkAddress
 */
class Event extends \application\models\translation\ActiveRecord
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

      'LinkAddress' => array(self::HAS_ONE, '\event\models\LinkAddress', 'EventId'),
      'Sections' => array(self::HAS_MANY, '\event\models\Section', 'EventId', 'order' => 'Sections.DatetimeStart ASC, Sections.DatetimeFinish ASC, Sections.Place ASC')
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
   * @param string $idName
   * @param bool $useAnd
   * @return Event
   */
  public function byIdName($idName, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.IdName = :IdName';
    $criteria->params = array('IdName' => $idName);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  public function bySearch($searchTerm, $locale = null, $useAnd)
  {
    $criteria = new \CDbCriteria();

    $searchTerm = trim($searchTerm);
    if (empty($searchTerm))
    {
      $criteria->addCondition('0=1');
      $this->getDbCriteria()->mergeWith($criteria, $useAnd);
      return $this;
    }
    $criteria->addCondition('t.Title LIKE :SearchTerm');
    $criteria->params['SearchTerm'] = '%' . \Utils::PrepareStringForLike($searchTerm) . '%';
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


  public function getUsingRoles()
  {
    $criteria = new \CDbCriteria();
    $criteria->group = 't.RoleId';
    $criteria->with  = array(
      'Role'
    );




    $participants = Participant::model()->byEventId($this->Id)->findAll($criteria);
    $result = array();
    foreach ($participants as $participant)
    {
      $result[] = $participant->Role;
    }
    return $result;
  }


  /******  OLD METHODS  ***/
  /** todo: REWRITE ALL BOTTOM */

  
  /**
   * Возвращает количество участников мероприятия
   * @return int
   */
  public function GetUsersCount()
  {
    $model = \user\models\User::model()->with('Settings', 'EventUsers');
    $criteria = new \CDbCriteria();
    $criteria->condition = 'Settings.Visible = :Visible AND EventUsers.EventId = :EventId';
    $criteria->params = array(':Visible' => '1', ':EventId' => $this->EventId);

    return intval($model->count($criteria));
  }

  /**
   * @param int $count
   * @param int|null $usersCount
   * @return \user\models\User[]
   */
  public function GetRandomUsers($count, $usersCount = null)
  {
    if (empty($usersCount))
    {
      $usersCount = $this->GetUsersCount();
    }
    
    $model = \user\models\User::model()->with('Settings', 'EventUsers')->together();
    $criteria = new \CDbCriteria();
    $criteria->condition = 'Settings.Visible = :Visible AND EventUsers.EventId = :EventId';
    $criteria->params = array(':Visible' => '1', ':EventId' => $this->EventId);
    $criteria->order = 'EventUsers.CreationTime';
    $criteria->limit = $count;
    $criteria->offset = rand(0, $usersCount - $count - 1);

    return $model->findAll($criteria);
  }

  public function GetEventDir($onServerDisc = false)
  {
    $result = \Yii::app()->params['EventDir'];
    if ($onServerDisc)
    {
      $result = $_SERVER['DOCUMENT_ROOT'] . $result;
    }

    return $result;
  }

  /**
   * Возвращает путь к мини изображению мероприятия, для списка мероприятий в профиле пользователя
   * @param bool $onServerDisc
   * @return string
   */
  public function GetMiniLogo($onServerDisc = false)
  {
    $name = 'minilogo/event_' . $this->GetIdName() . '.png';
    if ($onServerDisc)
    {
      return $this->GetEventDir($onServerDisc) . $name;
    }
    elseif (file_exists($this->GetEventDir(true) . $name))
    {
      return $this->GetEventDir($onServerDisc) . $name;
    }
    else
    {
      return $this->GetLogo($onServerDisc);
      //return $this->GetEventDir($onServerDisc) . 'none.png';
    }
//    $logo = (file_exists(Registry::GetVariable('PublicPath') .
//        Registry::GetVariable('EventDir') . 'event_' . $idname . '.png')) ?
//        'event_' . $idname . '.png' : 'none.png';
//    if ($logo != null)
//    {
//      $logo = Registry::GetVariable('EventLogoDir') . $logo;
//    }
//
//    return $logo;
  }

  /**
   * @param bool $onServerDisc
   * @return string
   */
  public function GetLogo($onServerDisc = false)
  {
    $name = 'logo/event_' . $this->GetIdName() . '.png';
    if ($onServerDisc)
    {
      return $this->GetEventDir($onServerDisc) . $name;
    }
    elseif (file_exists($this->GetEventDir(true) . $name))
    {
      return $this->GetEventDir($onServerDisc) . $name;
    }
    else
    {
      return $this->GetEventDir($onServerDisc) . 'none.png';
    }

//    $idname = $this->GetIdName();
//    $logo = (file_exists(Registry::GetVariable('PublicPath') .
//        Registry::GetVariable('EventLogoDir') . 'event_' . $idname . '.png')) ?
//        'event_' . $idname . '.png' : 'none.png';
//    if ($logo != null)
//    {
//      $logo = Registry::GetVariable('EventLogoDir') . $logo;
//    }
//
//    return $logo;
  }


}