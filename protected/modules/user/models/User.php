<?php
namespace user\models;

/**
 * @throws \Exception
 *
 * @property int $UserId
 * @property int $RunetId
 * @property string $LastName
 * @property string $FirstName
 * @property string $FatherName
 * @property string $Gender
 * @property string $Birthday
 * @property string $Email
 * @property string $CreationTime
 * @property string $UpdateTime
 * @property string $LastVisit
 * @property string $Password
 * @property string $OldPassword
 *
 * @property \contact\models\Address[] $Addresses
 * @property \contact\models\Phone[] $Phones
 * @property \contact\models\Site[] $Sites
 * @property \contact\models\ServiceAccount[] $ServiceAccounts
 * @property \contact\models\Email[] $Emails
 *
 * @property \event\models\Participant[] $Participants
 * @property \event\models\Event[] $Events
 * @property \event\models\Subscription[] $EventSubscriptions
 * @property \event\models\SectionHereService $EventProgramHere Функционал мобильной версии, позволяет пользователю отметиться на секции
 * @property \event\models\SectionUserLink[] $EventProgramUserLink
 *
 * @property Settings $Settings Настройки аккаунта пользователя
 * @property Connect[] $Connects
 *
 * @property Employment[] Employments
 *
 *
 * @property \CEvent $onRegister
 */
class User extends \application\components\ActiveRecord
{

	//Защита от перегрузки при поиске
	const MaxSearchFragments = 500;

  const PasswordLengthMin = 6;
	
	/**
	* @param string $className
	* @return User
	*/
	public static function model($className=__CLASS__)
	{    
		return parent::model($className);
	}
	
	public function tableName()
	{
		return 'User';
	}
	
	public function primaryKey()
	{
		return 'UserId';
	}

	public function relations()
	{
		return array(
		//Contacts
			'Addresses' => array(self::MANY_MANY, '\contact\models\Address', 'Link_User_ContactAddress(UserId, AddressId)',
				'with' => array('City')),
			'Phones' => array(self::MANY_MANY, '\contact\models\Phone', 'Link_User_ContactPhone(UserId, PhoneId)',
        'order' => 'Phones.PhoneId DESC'
      ),
			'ServiceAccounts' => array(self::MANY_MANY, '\contact\models\ServiceAccount', 'Link_User_ContactServiceAccount(UserId, ServiceId)',
				'with' => array('ServiceType')),
			'Sites' => array(self::MANY_MANY, '\contact\models\Site', 'Link_User_ContactSite(UserId, SiteId)'),
			'Emails' => array(self::MANY_MANY, '\contact\models\Email', 'Link_User_ContactEmail(UserId, EmailId)',
        'order' => 'Emails.Primary DESC'  
      ),
		//Event  
			'Participants' => array(self::HAS_MANY, '\event\models\Participant', 'UserId'),//, 'with' => array('Event', 'EventRole')),
			'Events' => array(self::MANY_MANY, 'Event', 'EventUser(UserId, EventId)'),
			'EventSubscriptions' => array(self::HAS_MANY, 'EventSubscription', 'UserId', 'with' => array('Event')),
			'EventProgramHere' => array(self::HAS_ONE, 'EventProgramHereService', 'UserId',),
      'EventProgramUserLink' =>array(self::HAS_MANY, 'EventProgramUserLink', 'UserId', 'with' => array('EventProgram', 'Role')),
		//User  
			'Activities' => array(self::HAS_MANY, 'UserActivity', 'UserId'),
			'Employments' => array(self::HAS_MANY, '\user\models\Employment', 'UserId', 'with' => 'Company' ,
				'order' => 'Employments.Primary DESC, Employments.FinishWorking DESC, Employments.StartWorking DESC'),
			'Settings' => array(self::HAS_ONE, '\user\models\Settings', 'UserId',),
			'Connects' => array(self::HAS_MANY, 'UserConnect', 'UserId'),
			//'InterestPersons' => array(self::HAS_MANY, 'UserInterestPerson', 'UserId', 'with' => array('InterestPerson')),   
			'InterestPersons' => array(self::MANY_MANY, 'User', 'UserInterestPerson(UserId, InterestPersonId)'),
			'MobilePassword' => array(self::HAS_ONE, 'UserMobilePassword', 'UserId',),

    //Access
      'Groups' => array(self::MANY_MANY, 'CoreGroup', 'Core_Link_UserGroup(UserId, GroupId)', 'with' => array('Masks')),
		);
	}
  
  public function rules() 
  {
    return array(
      array('FirstName, LastName, Password, Email', 'required'),
      array('Email', 'unique'),
      array('Email', 'email'),
      array('FatherName', 'safe')
    );
  }

  /**
   * @param int $runetId
   * @param bool $useAnd
   * @return User
   */
  public function byRunetId($runetId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.RunetId = :RunetId';
    $criteria->params = array(':RunetId' => $runetId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param int[] $runetIdList
   * @param bool $useAnd
   * @return User
   */
  public function byRunetIdList($runetIdList, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->addInCondition('t.RunetId', $runetIdList);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param string $email
   * @param bool $useAnd
   * @return User
   */
  public function byEmail($email, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.Email = :Email';
    $criteria->params = array(':Email' => $email);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param string $startTime
   * @param string $endTime
   * @param bool $useAnd
   * @return User
   */
  public function byRegisterTime($startTime = null, $endTime = null, $useAnd = true)
  {
    if ($startTime == null && $endTime == null)
    {
      return $this;
    }
    $criteria = new \CDbCriteria();
    if ($startTime != null)
    {
      $criteria->addCondition('t.CreationTime >= :StartTime');
      $criteria->params['StartTime'] = $startTime;
    }
    if ($endTime != null)
    {
      $criteria->addCondition('t.CreationTime <= :EndTime');
      $criteria->params['EndTime'] = $endTime;
    }
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param int $eventId
   * @param bool $useAnd
   * @return User
   */
  public function byEventId($eventId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->with = array('Participants' => array('together' => true));
    $criteria->addCondition('Participants.EventId = :EventId');
    $criteria->params['EventId'] = $eventId;
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }



  /**
   * @param string $searchTerm
   * @param string $locale
   * @param bool $useAnd
   * @return User
   */
  public function bySearch($searchTerm, $locale = null, $useAnd = true)
  {
    $searchTerm = trim($searchTerm);

    if (empty($searchTerm))
    {
      $criteria = new \CDbCriteria();
      $criteria->addCondition('0=1');
      $this->getDbCriteria()->mergeWith($criteria, $useAnd);
      return $this;
    }

    if (is_numeric($searchTerm) && intval($searchTerm) != 0)
    {
      return $this->byRunetId($searchTerm, $useAnd);
    }

    $parts = preg_split('/[, .]/', $searchTerm, self::MaxSearchFragments, PREG_SPLIT_NO_EMPTY);
    if (is_numeric($parts[0]) && intval($parts[0]) != 0)
    {
      return $this->bySearchNumbers($parts, $useAnd);
    }
    else
    {
      return $this->bySearchFullName($parts, $locale, $useAnd);
    }
  }

  /**
   * @param array $numbers
   * @param bool $useAnd
   * @return User
   */
  private function bySearchNumbers($numbers, $useAnd = true)
  {
    foreach ($numbers as $key => $value)
    {
      $numbers[$key] = intval($value);
    }
    return $this->byRunetIdList($numbers, $useAnd);
  }

  /**
   * @param string[] $names
   * @param string $locale
   * @param bool $useAnd
   * @throws \application\components\Exception
   * @return User
   */
  private function bySearchFullName($names, $locale = null, $useAnd = true)
  {
    if ($locale == \Yii::app()->sourceLanguage)
    {
      $criteria = new \CDbCriteria();
      $size = sizeof($names);
      if ($size == 1)
      {
        $criteria->condition = 't.LastName LIKE :Part0';
        $criteria->params = array(':Part0' => \Utils::PrepareStringForLike($names[0]) . '%');
      }
      elseif ($size == 2)
      {
        $criteria->condition = '(t.LastName LIKE :Part0 AND t.FirstName LIKE :Part1 OR ' .
          't.LastName LIKE :Part1 AND t.FirstName LIKE :Part0)';
        $criteria->params = array(':Part0' => \Utils::PrepareStringForLike($names[0]) . '%',
          ':Part1' => \Utils::PrepareStringForLike($names[1]) . '%');
      }
      else
      {
        $criteria->condition = 't.LastName LIKE :Part0 AND t.FirstName LIKE :Part1 AND ' .
          't.FatherName LIKE :Part2';
        $criteria->params = array(':Part0' => \Utils::PrepareStringForLike($names[0]) . '%',
          ':Part1' => \Utils::PrepareStringForLike($names[1]) . '%',
          ':Part2' => \Utils::PrepareStringForLike($names[2]) . '%');
      }
      $this->getDbCriteria()->mergeWith($criteria, $useAnd);
      return $this;
    }
    else
    {
      $fields = array();
      $keys = array('LastName', 'FirstName', 'FatherName');
      foreach ($keys as $key => $field)
      {
        if (isset($names[$key]))
        {
          $fields[$field] = $names[$key];
        }
      }
      //todo: исправить, когда модель юзер будет от перевода
      throw new \application\components\Exception('Не готов перевод локалей');
      return $this->byTranslationFields($locale, $fields);
    }
  }

  /**
   *
   * @return User
   */
  public function Register()
  {
    $password = $this->Password;
    $pbkdf2 = new \application\components\utility\Pbkdf2();
    $this->Password = $pbkdf2->createHash($password);
    $this->save();

    $event = new \CModelEvent($this, array('password' => $password));
    $this->onRegister($event);

    return $this;
  }

  public function onRegister($event)
  {
    $this->raiseEvent('onRegister', $event);
  }




  /******  OLD METHODS  ***/
  /** todo: REWRITE ALL BOTTOM */


	
	/**
	* Генерирует хеш-значение для проверки целостности cookie
	* 
	* @param string $userId
	* @return string
	*/
	public static function GenerateCookieHash($userId)
	{
		return md5($userId . microtime());
	}

  /**
   * Генерирует хеш-значение для хранения пароля
   * @static
   * @param  $password
   * @return string
   */
  public static function GetPasswordHash($password)
  {
    return md5($password);
  }
	
	/**
	* Проверяет, соответствуют ли rocId и password данному пользователю
	* 
	* @param string $rocId
	* @param string $password
	* @return bool
	*/
	public function CheckLogin($rocId, $password)
	{
    $password2 = iconv('utf-8', 'Windows-1251', $password);

    if ($this->RocId !== $rocId)
    {
      return false;
    }

    if ($this->Password === self::GetPasswordHash($password))
    {
      return true;
    }

    if ($this->Password === self::GetPasswordHash($password2))
    {
      $this->Password = self::GetPasswordHash($password);
      $this->save();
      return true;
    }

		return false;
	}

  /**
   * @param $hash Хэш пароля
   * @param $hash2 Хэш пароля в кодировке cp1251
   * @return bool
   */
  public function CheckLoginByHash($hash, $hash2)
  {
    if ($this->Password === $hash)
    {
      return true;
    }

    if ($this->Password === $hash2)
    {
      $this->Password = $hash;
      $this->save();
      return true;
    }

    return false;
  }

  /**
   * @return void
   */
  public function CreateSecretKey()
  {
    $key = User::GenerateCookieHash($this->UserId);
    $session = \Yii::app()->getSession();
    $session->add('rocid_hash', $key);
    $cookie = new \CHttpCookie('rocid_hash', $key);
    $cookie->expire = time() + \GeneralIdentity::GetExpire();
    \Cookie::Set($cookie);
  }

  public function CheckSecretKey()
  {
    $cookieKey = \Cookie::Get('rocid_hash');
    $sessionKey = \Yii::app()->getSession()->get('rocid_hash');
    if ( $cookieKey  == $sessionKey)
    {
      $cookie = new \CHttpCookie('rocid_hash', $cookieKey);
      $cookie->expire = time() + \GeneralIdentity::GetExpire();
      \Cookie::Set($cookie);
      return true;
    }
    return false;
  }
	
	/**
	* Разлогинивает данного пользователя
	* 
	*/
//	public function Logout()
//	{
//		Cookie::ResetCookie('RocId');
//		Cookie::ResetCookie('Password');
//		Cookie::ResetCookie('Hash');
//
//		$session = Session::GetInstance();
//		$session->Delete();
//	}
	
	/**
	* Проверяет, есть ли у данного пользователя админ доступ
	* 
	*/
	public function IsHaveAdminPermissions()
	{
		$adminIds = array(337, 454, 12953, 12959, 35287, 15648, 39948, 16670);
		if (in_array($this->GetRocId(), $adminIds))
		{
			return true;
		}
		return false;
	}

  /**
   * @return bool
   */
  public function CheckAccess()
  {
    //todo: replace by Yii access controll
    return false;
  }

  /**
   * @param bool $onServerDisc
   * @return string
   */
	public function GetPhotoDir($onServerDisc = false)
	{
		$rocId = $this->GetRocId();
		$folder = $rocId / 10000;
		$folder = (int)$folder;
		$result = \Yii::app()->params['UserPhotoDir'] . $folder . '/';
		if ($onServerDisc)
		{
			$result = $_SERVER['DOCUMENT_ROOT'] . $result;
		}
		return $result;
	}
	
	/**
	* Возвращает путь к мини изображению пользователя, для шапки сайта, отображения в компаниях и тп
	* @return string
	*/
	public function GetMiniPhoto()
	{    
		$rocId = $this->GetRocId();
		$folder = $this->GetPhotoDir();
		$photo = $rocId . '_50.jpg';
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . $folder . $photo))
		{
			return $folder . $photo;
		}
		else
		{
			return \Yii::app()->params['UserPhotoDir'] . 'nophoto_50.png';
		}
	}

	/**
	* Возвращает путь к мини изображению пользователя, для шапки сайта, отображения в компаниях и тп
	* @return string
	*/
	public function GetMediumPhoto()
	{
		$rocId = $this->GetRocId();
		$folder = $this->GetPhotoDir();
		$photo = $rocId . '_90.jpg';
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . $folder . $photo))
		{
			return $folder . $photo;
		}
		else
		{
			return \Yii::app()->params['UserPhotoDir'] . 'nophoto_90.png';
		}
	}

	/**
	* Возвращает путь к изображению пользователя для профиля и тп
	* @return string
	*/  
	public function GetPhoto()
	{
		$rocId = $this->GetRocId();
		$folder = $this->GetPhotoDir();
		$photo = $rocId . '_200.jpg';
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . $folder . $photo))
		{
			return $folder . $photo;
		}
		else
		{
			return \Yii::app()->params['UserPhotoDir'] . 'nophoto_200.png';
		}
	}

  /**
   * @param $image
   * @return void
   */
	public function SavePhoto($image)
	{
		$tmpName = DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR .
											 md5('user' . microtime()) . '.jpg';
		file_put_contents($tmpName, $image);

		$path = $this->GetPhotoDir(true);
		if (! is_dir($path))
		{
			mkdir($path);
		}

		$img = \application\components\graphics\Image::GetImage($tmpName);

		$namePrefix = $this->RocId;
		$clearSaveTo = $path . $namePrefix . '_clear.jpg';
		imagejpeg($img, $clearSaveTo, 100);
		$newImage = $path . $namePrefix . '.jpg';
		imagejpeg($img, $newImage, 100);
		imagedestroy($img);
		$newImage = $path . $namePrefix . '_200.jpg';
    \application\components\graphics\Image::ResizeAndSave($clearSaveTo, $newImage, 200, 0, array('x1'=>0, 'y1'=>0));
		$newImage = $path . $namePrefix . '_90.jpg';
    \application\components\graphics\Image::ResizeAndSave($clearSaveTo, $newImage, 90, 90, array('x1'=>0, 'y1'=>0));
		$newImage = $path . $namePrefix . '_50.jpg';
    \application\components\graphics\Image::ResizeAndSave($clearSaveTo, $newImage, 50, 50, array('x1'=>0, 'y1'=>0));
	}

  /**
   * Добавляет пользователю адрес электронной почты
   *
   * @param string $email
   * @param int $primary
   * @param int $personal
   * @return void
   */
	public function AddEmail($email, $primary = 0, $personal = 0)
	{
		$contactEmail = new \contact\models\Email();
		$contactEmail->Email = $email;
		$contactEmail->Primary = $primary;
		$contactEmail->IsPersonal = $personal;
		$contactEmail->save();
		
		$db = \Yii::app()->getDb();
		$sql = 'INSERT INTO Link_User_ContactEmail ( UserId , EmailId) VALUES (' . $this->UserId . ',' . $contactEmail->EmailId . ')';
		$db->createCommand($sql)->execute();
	}

	/**
	 * @param \contact\models\Site $site
	 * @return void
	 */
	public function AddSite($site)
	{
		$db = \Yii::app()->getDb();
		$sql = 'INSERT INTO Link_User_ContactSite ( UserId , SiteId) VALUES (' . $this->UserId . ',' . $site->SiteId . ')';
		$db->createCommand($sql)->execute();
	}

	/**
	 * @param \contact\models\Address $address
	 * @return void
	 */
	public function AddAddress($address)
	{
		$db = \Yii::app()->getDb();
		$sql = 'INSERT INTO Link_User_ContactAddress ( UserId , AddressId) VALUES (' . $this->UserId . ',' . $address->AddressId . ')';
		$db->createCommand($sql)->execute();
	}

	/**
	 * @param \contact\models\Phone $phone
	 * @return void
	 */
	public function AddPhone($phone)
	{
		$db = \Yii::app()->getDb();
		$sql = 'INSERT INTO Link_User_ContactPhone ( UserId , PhoneId) VALUES (' . $this->UserId . ',' . $phone->PhoneId . ')';    
		$db->createCommand($sql)->execute();
	}

	/**
	 * @param \contact\models\ServiceAccount $serviceAccount
	 * @return void
	 */
	public function AddServiceAccount($serviceAccount)
	{
		$db = \Yii::app()->getDb();
		$sql = 'INSERT INTO Link_User_ContactServiceAccount ( UserId , ServiceId) VALUES (' . $this->UserId . ',' . $serviceAccount->ServiceId . ')';
		$db->createCommand($sql)->execute();
	}

	/**
	 * @param int|\contact\models\Site $site
	 * @return void
	 */
	public function DeleteSite($site)
	{
		if (is_object($site))
		{
			$site = $site->SiteId;
		}
		$db = \Yii::app()->getDb();
		$sql = 'DELETE FROM Link_User_ContactSite WHERE UserId = ' . $this->UserId .' AND SiteId = ' . $site;
		$db->createCommand($sql)->execute();
	}

	/**
	 * @param int|\contact\models\Phone $phone
	 * @return void
	 */
	public function DeletePhone($phone)
	{
		if (is_object($phone))
		{
			$phone = $phone->PhoneId;
		}
		$db = \Yii::app()->getDb();
		$sql = 'DELETE FROM Link_User_ContactPhone WHERE UserId = ' . $this->UserId .' AND PhoneId = ' . $phone;
		$db->createCommand($sql)->execute();
	}

	/**
	 * @param int|\contact\models\ServiceAccount $serviceAccount
	 * @return void
	 */
	public function DeleteServiceAccount($serviceAccount)
	{
		if (is_object($serviceAccount))
		{
			$serviceAccount = $serviceAccount->ServiceId;
		}
		$db = \Yii::app()->getDb();
		$sql = 'DELETE FROM Link_User_ContactServiceAccount WHERE UserId = ' . $this->UserId .' AND ServiceId = ' . $serviceAccount;
		$db->createCommand($sql)->execute();
	}
	
	/**
	* Создает настройки пользователя, либо возвращает имеющиеся - если они уже существуют
	* @return Settings
	*/
	public function CreateSettings()
	{
		$settings = $this->Settings;
		if ($settings == null)
		{
			$settings = new Settings();
			$settings->UserId = $this->GetUserId();
			$settings->Visible = 1;
			$settings->save();
      $this->Settings = $settings;
		}
		return $settings;
	}

  /**
   * Обновляет последнее посещение пользователя
   * @return void
   */
  public function UpdateLastVisit()
  {
    $db = \Yii::app()->getDb();
    $db->createCommand()->update(self::$TableName, array('LastVisit' => time()), 'UserId = :UserId', array(':UserId' => $this->UserId));
  }
	
	/**
	* Проверяет, зарегистрирован ли пользователь на мероприятии с таким Id
	* 
	* @param int $eventId
	* @return boolean
	*/
	public function IsRegisterOnEvent($eventId)
	{
		$eventUser = \event\models\Participant::model();
		$criteria = new \CDbCriteria();
		$criteria->condition = 't.UserId = :UserId AND t.EventId = :EventId';
		$criteria->params = array(':UserId' => $this->UserId, ':EventId' => $eventId);
		$count = $eventUser->count($criteria);
		return $count > 0;
	}
	
	/**
	* Возвращает всех интересующих персон данного пользователя
	* 
	* @param $withParam
	* @return array[User]
	*/
	public function GetInterestPersonsWith($withParam)
	{
		return $this->InterestPersons(array('with' => $withParam));
	}

  public function Hide()
  {
    $this->Settings->Visible = 0;
    $this->Settings->save();
  }


  private $primaryEmployment;
  /**
   * @return Employment|null
   */
  public function GetPrimaryEmployment()
  {
    if (empty($this->primaryEmployment))
    {
      $this->primaryEmployment = null;
      foreach ($this->Employments as $employment)
      {
        if ($employment->Primary == 1)
        {
          $this->primaryEmployment = $employment;
          break;
        }
      }
    }
    return $this->primaryEmployment;
  }
		
	/**
	* Геттеры и сеттеры для полей
	*/
	//UserId
	public function GetUserId()
	{
		return $this->UserId;
	}  
	//Rocid
	public function GetRocId()
	{
		return $this->RocId;
	}
	
	public function SetRocId($value)
	{
		$this->RocId = $value;
	}
	//LastName
	public function GetLastName()
	{
		return $this->LastName;
	}
	
	public function SetLastName($value)
	{
		$this->LastName = $value;
	}
	//FirstName
	public function GetFirstName()
	{
		return $this->FirstName;
	}
	
	public function SetFirstName($value)
	{
		$this->FirstName = $value;
	}
	//FatherName
	public function GetFatherName()
	{
		return $this->FatherName;
	}
	
	public function SetFatherName($value)
	{
		$this->FatherName = $value;
	}
	//Sex
	public function GetSex()
	{
		return $this->Sex;
	}
	
	public function SetSex($value)
	{
		$this->Sex = $value;
	}
	//Birthday
	public function GetBirthday()
	{
		return $this->Birthday;
	}
	
	/**
	* Возвращает ассоциативный массив с полями day, month, year
	* 
	* @return array
	*/
	public function GetParsedBirthday()
	{
		$birthday = $this->Birthday;
		$result = array();

		$result['year'] = intval(substr($birthday, 0, 4));
		$result['month'] = intval(substr($birthday, 5, 2));
		$result['day'] = intval(substr($birthday, 8, 2));

		return $result;
	}

	/**
	 * Устанавливает корректную дату рождения из массива day, month, year
	 * @param array $date
	 * @return void
	 */
	public function SetParsedBirthday($date)
	{
		if (empty($date['year']) || intval($date['year']) == 0)
		{
			$birthday = '0000';
		}
		else
		{
			$birthday = $date['year'];
		}
		$birthday .= '-';
		if (empty($date['month']) || intval($date['month']) == 0)
		{
			$birthday .= '00';
		}
		else
		{
			$birthday .= $date['month'];
		}
		$birthday .= '-';
		if (empty($date['day']) || intval($date['day']) == 0)
		{
			$birthday .= '00';
		}
		else
		{
			$birthday .= $date['day'];
		}
		$this->Birthday = $birthday;
	}
	
	public function SetBirthday($value)
	{
		$this->Birthday = $value;
	}
	//Password
	public function GetPassword()
	{
		return $this->Password;
	}
	
	public function SetPassword($value)
	{
		$this->Password = $value;
	}
	//CreationTime
	public function GetCreationTime()
	{
		return $this->CreationTime;
	}
	
	public function SetCreationTime($value)
	{
		$this->CreationTime = $value;
	}
	//UpdateTime
	public function GetUpdateTime()
	{
		return $this->UpdateTime;
	}
	
	public function SetUpdateTime($value)
	{
		$this->UpdateTime = $value;
	}
	//LastVisit
	public function GetLastVisit()
	{
		return $this->LastVisit;
	}
	
	public function SetLastVisit($value)
	{
		$this->LastVisit = $value;
	}
	//Referral
	public function GetReferral()
	{
		return $this->Referral;
	}
	
	public function SetReferral($value)
	{
		$this->Referral = $value;
	}
	
	/**
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
	* @return \contact\models\Site
	*/
	public function GetSite()
	{
		$sites = $this->Sites;
		if (isset($sites[0]))
		{
			return $sites[0];
		}
		else
		{
			return null;
		}
	}
	
	/**
	* @return \contact\models\Email
	*/
	public function GetEmail()
	{
		$emails = $this->Emails;    
		if (isset($emails[0]))
		{
			return $emails[0];
		}
		else
		{
			return null;
		}
	}
	
	/**
	* @return \contact\models\ServiceAccount[]
	*/
	public function GetServiceAccounts()
	{
		return $this->ServiceAccounts;
	}

	/**
	 * @return \contact\models\Phone[]
	 */
	public function GetPhones()
	{
		return $this->Phones;
	}

	/**
	* @return Employment[]
	*/
	public function GetEmployments()
	{
		return $this->Employments;
	}
	

	/**
	* @return array[Event]
	*/
	public function GetEvents()
	{
		return $this->Events;
	}
	
	/**
	* Возвращает массив с элементами EventSubscription, Event 
	* загружается автоматически с использованием жадной загрузки
	* 
	* @return array[EventSubscription]
	*/
	public function GetEventSubscriptions()
	{
		return $this->EventSubscriptions;
	}
	


  /**
   * Возвращает основное место работы (либо последнее место работы, если по каким то причинам основное не указано)
   * @return Employment|null
   */
  public function EmploymentPrimary()
  {
    return !empty($this->Employments) ? $this->Employments[0] : null;
  }
  
  public function GetFullName ()
  {    
      $fullName = $this->LastName .' '. $this->FirstName;
      if ($this->Settings->HideFatherName == 0) {
          $fullName .= ' '. $this->FatherName;
      }
      return $fullName;
  }
  
  /**
   * Уставливает место работы пользователю
   * @param string $companyName
   * @param string $position
   * @param array $from
   * @param array $to 
   */
  public function addEmployment($companyName, $position, $from = array(), $to = array())
  {
    if (!empty($this->Employments))
    {
      foreach ($this->Employments as $employment)
      {
        $employment->Primary = 0;
        $employment->save();
      }
    }
    
    $companyInfo = \company\models\Company::ParseName($companyName);
    $company = \company\models\Company::GetCompanyByName($companyInfo['name']);
    if ($company == null)
    {
      $company = new \company\models\Company();
      $company->Name = $companyInfo['name'];
      $company->Opf = $companyInfo['opf'];
      $company->CreationTime = time();
      $company->UpdateTime = time();
      $company->save();
    }

    $employment = new \user\models\Employment();
    $employment->UserId = $this->UserId;
    $employment->CompanyId = $company->CompanyId;
    $employment->SetParsedStartWorking($from);
    $employment->SetParsedFinishWorking($to);
    $employment->Position = $position;
    $employment->Primary = 1;
    $employment->save();
  }
}