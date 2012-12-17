<?php
namespace event\models;

/**
 * @property int $Id
 * @property string $IdName
 * @property string $Title
 * @property string $Info
 * @property string $FullInfo
 * @property string $Place
 * @property string $Start
 * @property string $End
 * @property bool $Visible
 *
 *
 * @property string $Type
 *
 * @property string $Url
 * @property string $UrlRegistration
 * @property string $UrlProgram
 * @property string $UrlProgramMask
 *
 *
 * @property int $FastRole
 * @property int $DefaultRoleId
 * @property string $FastProduct
 *
 * @property int $Order
 *
 *
 *
 *
 * @property Day[] $Days
 * @property Section[] $Sections
 * @property Role $DefaultRole
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




      'Days' => array(self::HAS_MANY, '\event\models\Day', 'EventId'),
      //User
      'Participants' => array(self::HAS_MANY, '\event\models\Participant', 'EventId', 'with' => array('Role')),
      'Users' => array(self::MANY_MANY, '\user\models\User', 'EventUser(EventId, UserId)', 'with' => 'Settings', 'condition' => 'Settings.Visible = \'1\''),


      'Phones' => array(self::MANY_MANY, 'ContactPhone', 'Link_Event_ContactPhone(EventId, PhoneId)'),
      'Addresses' => array(self::MANY_MANY, '\contact\models\Address', 'Link_Event_ContactAddress(EventId, AddressId)', 'with' => array('City')),

      'Sections' => array(self::HAS_MANY, '\event\models\Section', 'EventId', 'order' => 'Sections.DatetimeStart ASC, Sections.DatetimeFinish ASC, Sections.Place ASC'),
      'DefaultRole' =>  array(self::BELONGS_TO, '\event\models\Role', 'DefaultRoleId'),
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


  public function registerUser(\user\models\User $user, Role $role)
  {

  }


  /******  OLD METHODS  ***/
  /** todo: REWRITE ALL BOTTOM */



  /**
   * @param \user\models\User $user
   * @param Role $role
   * @throws \Exception
   * @return Participant|null
   */
  public function RegisterUser1(\user\models\User $user, Role $role)
  {
    if (!empty($this->Days))
    {
      throw new \Exception('Данное мероприятие имеет логическую разбивку. Используйте метод добавления участия в конкретный день.');
    }
    $eventUser = Participant::model()->byEventId($this->EventId)->byUserId($user->UserId)->byDayNull()->find();
    if (empty($eventUser))
    {
      $eventUser = $this->registerUserUnsafe($user, $role);
      $this->notifyAboutRegistration($user);
      return $eventUser;
    }
    return null;
  }

  public function RegisterUserOnAllDays(\user\models\User $user, Role $role)
  {
    $result = array();
    foreach ($this->Days as $day)
    {
      $result[$day->DayId] = $this->RegisterUserOnDay($day, $user, $role);
    }
    return $result;
  }

  public function RegisterUserOnDay(Day $day, \user\models\User $user, Role $role)
  {
    $participant = Participant::model()->byEventId($this->EventId)->byUserId($user->UserId)->byDayId($day->DayId)->find();
    if (empty($participant))
    {
      $participant = $this->registerUserUnsafe($user, $role, $day);
      $this->notifyAboutRegistration($user);
      return $participant;
    }
    return null;
  }

  private function registerUserUnsafe(\user\models\User $user, Role $role, Day $day = null)
  {
    $eventUser = new Participant();
    $eventUser->EventId = $this->EventId;
    $eventUser->DayId = ($day != null) ? $day->DayId : null;
    $eventUser->UserId = $user->UserId;
    $eventUser->RoleId = $role->RoleId;
    $eventUser->Approve = 0;
    $eventUser->CreationTime = $eventUser->UpdateTime = time();
    $eventUser->save();

    return $eventUser;
  }

  private function notifyAboutRegistration(\user\models\User $user)
  {
    /** @var $partnerAccount \partner\models\Account */
    $partnerAccount = \partner\models\Account::model()->byEventId($this->EventId)->find();
    if (!empty($partnerAccount))
    {
      $partnerAccount->GetNotifier()->NotifyNewParticipant($user);
    }
  }

  /**
   *
   * @return array
   */
  public function Statistics()
  {
    $result = \Yii::app()->getDb()->createCommand()->select('COUNT(e.UserId) CountByRole, e.RoleId')->from('Event e')
      ->where('e.EventId = :EventId', array(':EventId' => $this->EventId))->group('e.RoleId')->queryAll();

    print_r($result);
    return array();
  }

  public function GetUsingRoles ()
  {
      $criteria = new \CDbCriteria();
      $criteria->condition = 't.EventId = :EventId';
      $criteria->params[':EventId'] = $this->EventId;
      $criteria->group = 't.RoleId';
      $criteria->with  = array(
          'Role'
      );
      
      $result = array();
      
      $participants = Participant::model()->findAll($criteria);
      foreach ($participants as $participant)
      {
          $result[] = $participant->Role;
      }
      return $result;
  }
  
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


  /**
  * 
  * @param \CDBCriteria|array $params
  * @return array[User]
  */  
  public function GetUsers($params = array())
  {
    if (empty($params))
    {
      return $this->Users;
    }
    else
    {
      return $this->Users($params);
    }    
  }

  /**
  * Геттеры и сеттеры для полей
  */
  public function GetEventId()
  {
    return $this->EventId;
  }  
  
  //IdName
  public function GetIdName()
  {
    return $this->IdName;
  }
  
  public function SetIdName($value)
  {
    $this->IdName = $value;
  }
  
  //ShortName
  public function GetShortName()
  {
    return $this->ShortName;
  }
  
  public function SetShortName($value)
  {
    $this->ShortName = $value;
  }
  
  //Name
  public function GetName()
  {
    return stripslashes($this->Name);
  }
  
  public function SetName($value)
  {
    $this->Name = $value;
  }
  
  //Type
  public function GetType()
  {    
    return $this->Type;
  }
  
  public function SetType($value)
  {
    $this->Type = $value;
  }
  
  //Info
  public function GetInfo()
  {
    return stripslashes($this->Info);
  }
  
  public function SetInfo($value)
  {
    $this->Info = $value;
  }
  
  //Info
  public function GetFullInfo()
  {
    return stripslashes($this->FullInfo);
  }
  
  public function SetFullInfo($value)
  {
    $this->FullInfo = $value;
  }
  
   //Place
  public function GetPlace()
  {
    return stripslashes($this->Place);
  }
  
  public function SetPlace($value)
  {
    $this->Place = $value;
  }
  
   //Comment
  public function GetComment()
  {
    return $this->Comment;
  }
  
  public function SetComment($value)
  {
    $this->Comment = $value;
  }

  //Url
  public function GetUrl()
  {
    return $this->Url;
  }
  
  public function SetUrl($value)
  {
    $this->Url = $value;
  }

  private function parseDate($date)
  {
    $result['year'] = intval(substr($date, 0, 4));
    $result['month'] = intval(substr($date, 5, 2));
    $result['day'] = intval(substr($date, 8, 2));

    return $result;
  }

  public function GetParsedDateStart()
  {
    return $this->parseDate($this->DateStart);
  }
  
  public function GetDateStart()
  {
    return $this->DateStart;
  }
  
  public function SetDateStart($value)
  {
    $this->DateStart = $value;
  }

  public function GetParsedDateEnd()
  {
    return $this->parseDate($this->DateEnd);
  }
  
  public function GetDateEnd()
  {
    return $this->DateEnd;
  }
  
  public function SetDateEnd($value)
  {
    $this->DateEnd = $value;
  }
  
  //Visible
  public function GetVisible()
  {
    return $this->Visible;
  }
  
  public function SetVisible($value)
  {
    $this->Visible = $value;
  }
  
   //Order
  public function GetOrder()
  {
    return $this->Order;
  }
  
  public function SetOrder($value)
  {
    $this->Order = $value;
  }
  
  /**
  * @desc Адрес мероприятия
  * @return \contact\models\Address
  */
  public function GetAddress()
  {

    $addresses = $this->Addresses;
    if (isset($addresses[0]))
    {
      return $addresses[0];
    }
    else
    {
      return null;
    }
  }

  /**
  * @desc Телефоны организаторов мероприятия
  * 
  * @return \contact\models\Phone[]
  */
  public function GetPhones()
  {
    return $this->Phones;
  }
}