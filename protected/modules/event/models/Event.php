<?php
namespace event\models;

/**
 * @property int $EventId
 * @property string $IdName
 * @property string $ShortName
 * @property string $Name
 * @property string $Type
 * @property string $Info
 * @property string $FullInfo
 * @property string $Place
 * @property string $Comment
 * @property string $Url
 * @property string $UrlRegistration
 * @property string $UrlProgram
 * @property string $UrlProgramMask
 * @property string $DateStart
 * @property string $DateEnd
 * @property int $FastRole
 * @property int $DefaultRoleId
 * @property string $FastProduct
 * @property string $Visible
 * @property int $Order
 *
 *
 *
 *
 * @property Day[] $Days
 * @property Section[] $Sections
 * @property Role $DefaultRole
 */
class Event extends \CActiveRecord
{
  public static $TableName = 'Event';
  //Константы для описания полноты загрузки модели
  const LoadOnlyEvent = 0;  
  const LoadEventAndContacts = 1;
  const LoadFullInfo = 2;

  const EventTypeOwn = 'own';
  const EventTypePartner = 'partner';

  const EventVisibleY = 'Y';
  const EventVisibleN = 'N';
  
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
    return 'EventId';
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
  * 
  * @param int $loadingDepth
  * @return Event Модель пользователя, для последующего обращения к БД.
  */
  protected static function GetLoadingDepth($loadingDepth)
  {    
    switch ($loadingDepth)
    {  
      case self::LoadFullInfo:
        $event = Event::model()->with('EventUsers', 'Users')->together();
        return $event;
      case self::LoadEventAndContacts:
        $event = Event::model()->with('Phones', 'Addresses')->together();
        return $event;
      case self::LoadOnlyEvent:
      default:
        $event = Event::model();
        return $event;
    }
  } 
  
  
  /**
  * 
  * @param int $eventId
  * @param int $loadingDepth
  * @return Event
  */
  public static function GetById($eventId, $loadingDepth = self::LoadOnlyEvent)
  {    
    $event = self::GetLoadingDepth($loadingDepth);    
    return $event->findByPk($eventId);
  }
  
  /**
  * Возвращает мероприятие, по его текстовому идентификатору
  * @param string $idName
  * @param int $loadingDepth
  * @return Event
  */
  public static function GetEventByIdName($idName, $loadingDepth = self::LoadOnlyEvent)
  {
    $event = self::GetLoadingDepth($loadingDepth);
    $criteria = new \CDbCriteria();
    $criteria->condition =  't.IdName = :IdName';
    $criteria->params = array(':IdName' => $idName);    
    return $event->find($criteria);
  }
  
  public static function GetSearchCriteria($searchTerm)
  {    
    $searchTerm = trim($searchTerm);
    if (empty($searchTerm))
    {
      return null;
    }
    $criteria = new \CDbCriteria();
    
    $criteria->condition = 't.ShortName LIKE :SearchTerm OR t.Name LIKE :SearchTerm';
    $criteria->order = 't.DateStart DESC, t.Name DESC';
    $criteria->params = array(':SearchTerm' => '%' . \Utils::PrepareStringForLike($searchTerm) . '%');
    return $criteria;
  }
  
  /**
  * Возвращает последние состоявшиеся $num мероприятий
  * 
  * @param int $num
  * @return Event[]
  */
  public static function GetLastEvents($num)
  {
    $event = self::GetLoadingDepth(self::LoadOnlyEvent);
    
    $criteria = new \CDbCriteria();
    $criteria->condition = 'DateStart < :TimeNow';
    $criteria->limit = $num;
    $criteria->order = 'DateStart DESC';
    $criteria->params = array(':TimeNow' => date('Y-m-d', time()));
    
    return $event->findAll($criteria);
  }
  
  /**
  * Возвращает гредущие $num мероприятий
  * 
  * @param int $num
  * @return Event[]
  */  
  public static function GetFutureEvents($num)
  {
    $event = self::GetLoadingDepth(self::LoadOnlyEvent);
    
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.DateStart > :TimeNow AND t.Visible = \'Y\'';
    $criteria->limit = $num;
    $criteria->order = 't.DateStart, t.DateEnd';
    $criteria->params = array(':TimeNow' => date('Y-m-d', time()));
    
    return $event->findAll($criteria);
  }
  
  /**
  * Возвращает гредущие мероприятий, начинающиеся не позднее $limitDate
  * 
  * @param int $limitDate
  * @return array[Event]
  */ 
  public static function GetFutureEventsByDate($limitDate)
  {
    $event = self::GetLoadingDepth(self::LoadOnlyEvent);
    
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.DateStart > :TimeNow AND t.DateStart < :LimitDate  AND t.Visible = \'Y\'';
    $criteria->order = 'DateStart';
    $criteria->params = array(':TimeNow' => time(), ':LimitDate' => $limitDate);
    
    return $event->findAll($criteria);
  }
  
  /**
  * Возвращает проходящие в данный момент мероприятия и прошедшие мероприятия, 
  * но закончившиеся не позднее $limitDate
  * 
  * @param int $limitDate
  * @return array[Event]
  */
  public static function GetProgressEvents($limitDate)
  {
    $event = self::GetLoadingDepth(self::LoadOnlyEvent);
    
    $criteria = new \CDbCriteria();
    $criteria->condition = '(t.DateStart < :TimeNow AND t.DateStart > :LimitDate
      OR t.DateStart < :TimeNow AND t.DateEnd > :TimeNow
      OR t.DateEnd > :TimeNow AND t.DateEnd < :LimitDate) AND t.Visible = \'Y\'';
    $criteria->order = 'DateEnd';
    $criteria->params = array(':TimeNow' => time(), ':LimitDate' => $limitDate);
    
    return $event->findAll($criteria);
  }
  
  /**
  * @param string $dateStart Y-m-d
  * @param string $dateEnd Y-m-d
  * 
  * @return Event[]
  */
  public static function GetEventsByDates($dateStart, $dateEnd)
  {
    $event = self::GetLoadingDepth(self::LoadOnlyEvent);
    
    $criteria = new \CDbCriteria();
    $criteria->condition = '(t.DateStart >= :DateStart AND t.DateStart <= :DateEnd
      OR t.DateEnd >= :DateStart AND t.DateEnd <= :DateEnd
      OR t.DateStart <= :DateStart AND t.DateEnd >= :DateEnd)  AND t.Visible = \'Y\'';
    $criteria->order = 'DateStart, DateEnd';
    $criteria->params = array(':DateStart' => $dateStart, ':DateEnd' => $dateEnd);
    
    return $event->findAll($criteria);
  }

  /**
   * @static
   * @param string $dateStart Y-m-d
   * @param int $num
   * @return Event[]
   */
  public static function GetFutureEventsFromDate($dateStart, $num)
  {
    $event = self::GetLoadingDepth(self::LoadOnlyEvent);

    $criteria = new \CDbCriteria();
    $criteria->condition = '(t.DateStart >= :DateStart OR t.DateEnd >= :DateStart) AND t.Visible = \'Y\'';
    $criteria->order = 'DateStart, DateEnd';
    $criteria->limit = $num;
    $criteria->params = array(':DateStart' => $dateStart);

    return $event->findAll($criteria);
  }

  public static $GetByPageCountLast;
  /**
   * @static
   * @param int $count
   * @param int $page
   * @return Event[]
   */
  public static function GetByPage($count, $page = 1)
  {
    $event = self::GetLoadingDepth(self::LoadOnlyEvent);
    self::$GetByPageCountLast = $event->count();

    $criteria = new \CDbCriteria();
    $criteria->limit = $count;
    $criteria->offset = $count * ($page - 1);
    $criteria->order = 't.DateStart DESC, t.DateEnd DESC';
    return $event->findAll($criteria);
  }

  /**
   * Возвращает уникальный строковый идентификатор мероприятия
   * @static
   * @param string $baseName
   * @return string
   */
  public static function GetUniqueIdName($baseName)
  {
    $counter = 0;
    $name = $baseName;
    $test = 1;
    while (! empty($test))
    {
      if (! empty($counter))
      {
        $name = $baseName . '_' . $counter;
      }
      $test = Event::GetEventByIdName($name);
      $counter++;
    }

    return $name;
  }

  /**
   * @param \user\models\User $user
   * @param Role $role
   * @throws \Exception
   * @return Participant|null
   */
  public function RegisterUser(\user\models\User $user, Role $role)
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