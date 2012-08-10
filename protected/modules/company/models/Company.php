<?php
namespace company\models;


/**
 * @throws \Exception
 *
 * @property int $CompanyId
 * @property string $Name
 * @property string $FullName
 * @property string $Info
 * @property string $Opf
 * @property string $OrgName
 * @property int $CreationTime
 * @property int $UpdateTime
 *
 * @property \contact\models\Email[] $Emails
 * @property \contact\models\Address[] $Addresses
 * @property \contact\models\Phone[] $Phones
 * @property \contact\models\Site[] $Sites
 * @property \contact\models\ServiceAccount[] $ServiceAccounts
 * @property \user\models\Employment[] $Employments
 * @property \user\models\Employment[] $EmploymentsAll
 * @property \user\models\User[] $Editors
 */
class Company extends \CActiveRecord
{
	
	public static $TableName = 'Company';
	//Константы для описания полноты загрузки модели
	const LoadOnlyCompany = 0;
	const LoadFullInfo = 1;
	const LoadMiddleInfo = 2;
	const LoadContactInfo = 3;

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
		return 'CompanyId';
	}

  public function relations()
  {
    return array(
      //Контакты
      'Sites' => array(self::MANY_MANY, 'ContactSite', 'Link_Company_ContactSite(CompanyId, SiteId)'),
      'Emails' => array(self::MANY_MANY, 'ContactEmail', 'Link_Company_ContactEmail(CompanyId, EmailId)'),
      'Phones' => array(self::MANY_MANY, 'ContactPhone', 'Link_Company_ContactPhone(CompanyId, PhoneId)'),
      'Addresses' => array(self::MANY_MANY, 'ContactAddress', 'Link_Company_ContactAddress(CompanyId, AddressId)',
                           'with' => array('City')),
      'ServiceAccounts' => array(self::MANY_MANY, 'ContactServiceAccount', 'Link_Company_ContactServiceAccount(CompanyId, ServiceId)',
                                 'with' => array('ServiceType')),
      //Сотрудники
      'Employments' => array(self::HAS_MANY, 'UserEmployment', 'CompanyId',
                       'order' => 'Users.FinishWorking DESC', 'condition' => 'Users.FinishWorking > CURDATE()', 'with' => array('User')),
      'EmploymentsAll' => array(self::HAS_MANY, 'UserEmployment', 'CompanyId',
                          'order' => 'UsersAll.FinishWorking DESC', 'with' => array('User')),
      //Редакторы компании
      'Editors' => array(self::MANY_MANY, 'User', 'CompanyEditor(CompanyId, UserId)'),
      //Event
//    'EventUsers' => array(self::HAS_MANY, 'EventUser', 'UserId'),
    );
  }
	
	/**
	* 
	* @param int $loadingDepth
	* @return Company Модель пользователя, для последующего обращения к БД.
	*/
	protected static function GetLoadingDepth($loadingDepth)
	{
		switch ($loadingDepth)
		{  
			// Полная загрузка данных по компании (Контактные данные, сотрудники, мероприятия в кот. участвовали сотрудники)
			case self::LoadFullInfo:
				$company = Company::model()->with('Emails', 'Phones', 'Addresses.City.Country', 'UsersAll.User.EventUsers.Event');//->together();
				return $company;
				
			// Частичная загрузка данных по компании (контактные данные, сотрудники)
			case self::LoadMiddleInfo:
				$company = Company::model()->with('Emails', 'Phones', 'Addresses.City.Country', 'UsersAll');//->together();
				return $company;

			case self::LoadContactInfo:
				$company = Company::model()->with('Emails', 'Phones', 'Addresses.City.Country');//->together();
				return $company;

			case self::LoadOnlyCompany:

			default:
				$company = Company::model();
				return $company;
		}
	}

  /**
   * @static
   * @param $companyId
   * @param int $loadingDepth
   * @return Company
   */
	public static function GetById($companyId, $loadingDepth = self::LoadOnlyCompany)
	{    
		$company = self::GetLoadingDepth($loadingDepth);    
		$criteria = new \CDbCriteria();
		$criteria->condition = 't.CompanyId = :CompanyId';
		$criteria->params = array(':CompanyId' => $companyId);
		return $company->find($criteria);
	}

	/**
	 * @static
	 * @param string $name
	 * @param int $loadingDepth
	 * @return Company
	 */
	public static function GetCompanyByName($name, $loadingDepth = self::LoadOnlyCompany)
	{
		$company = self::GetLoadingDepth($loadingDepth);
		$criteria = new \CDbCriteria();
		$criteria->condition = 't.Name LIKE :Name';
		$criteria->params = array(':Name' => $name);
		return $company->find($criteria);
	}
	
	/**
	* Загружает компании по заданному первому символу фамилии, региону и номеру страницы индексации
	* 
	* @param string $letter
	* @param array $location
	* @param int $currentPage
	* @return array[mixed] Возвращает ассоциативный массив, users - пользователи текущей страницы, count - суммарное количество пользователей
	*/
	public static function GetCompanyList($letter, $location, $currentPage = 1)
	{
		$currentPage = max(array(1, $currentPage));
		$companyPerPage = \Yii::app()->params['CompanyPerPage'];
		
		$with = array('Addresses.City');
		
		$company = Company::model()->with($with)->together();
		
		

		$criteria = new \CDbCriteria();
		$criteria->condition = '';
		$criteria->params = array();
		if ($location['city'] != 0)
		{
			$criteria->condition =  'Addresses.CityId = :CityId';
			$criteria->params = array(':CityId' => $location['city']);
		}
		else if ($location['region'] != 0)
		{
			$criteria->condition =  'City.RegionId = :RegionId';
			$criteria->params = array(':RegionId' => $location['region']);
		}
		else if ($location['country'] != 0)
		{
			$criteria->condition =  'City.CountryId = :CountryId';
			$criteria->params = array(':CountryId' => $location['country']);      
		}
		
		if ($letter != 'all')
		{
			$criteria->condition .= ! empty($criteria->condition) ? ' AND ' : ' ';
			$criteria->condition .= 't.Name LIKE :Letter';
			$criteria->params[':Letter'] = $letter . '%';
		}
		$criteria->limit = $companyPerPage;    
		
		$count = $company->count($criteria);
		
		$criteria->offset = ($currentPage - 1) * $companyPerPage;
		$criteria->order = 't.Name';
		$companies = $company->findAll($criteria);
		
//    $companyListId = array();
//    foreach ($companies as $c)
//    {
//      $companyListId[] = $c->GetCompanyId();
//    }
		
		$result = array();
		$result['companies'] = $companies;//array();
		$result['count'] = $count;
//    if (! empty($userListId))
//    {
//      $with = array('Addresses.City.Country');
//      $user = User::model()->with($with)->together();
//      $criteria = new CDbCriteria();
//      $criteria->condition =  't.UserId IN (' . implode(',', $userListId) . ')';
//      $criteria->order = 'LastName, FirstName';
//      $result['users'] = $user->findAll($criteria);
//    }
		
		return $result;
	}

	public static $GetBySearchCount = 0;
	/**
	 * @static
	 * @param string $searchTerm
	 * @param int $count
	 * @param int $page
	 * @param bool $calcCount
	 * @param bool $onlyCount
	 * @return Company[]
	 */
	public static function GetBySearch($searchTerm, $count = 20, $page = 1,
		$calcCount = false, $onlyCount = false)
	{
		$company = Company::model();

		$criteria = new \CDbCriteria();
		$criteria->condition = 'MATCH (Name) AGAINST (:Name)';
		$criteria->params = array(':Name' => $searchTerm);

		if ($calcCount || $onlyCount)
		{
			self::$GetBySearchCount = $company->count($criteria);
			if (self::$GetBySearchCount == 0 || $onlyCount)
			{
				return array();
			}
		}
		$company = $company->with(array('Users', 'Addresses.City'));
		$criteria->offset = ($page - 1) * $count;
		$criteria->limit = $count;
		return $company->findAll($criteria);
	}


  /**
   * @static
   * @param string $name
   * @param int $count
   * @param int $loadingDepth
   * @return Company[]
   */
	public static function SearchCompaniesByName($name, $count, $loadingDepth = self::LoadOnlyCompany)
	{
		$criteria = self::GetSearchCriteria($name);
		$criteria->order = 't.Name';
		$criteria->limit = $count;
		$company = self::GetLoadingDepth($loadingDepth);
		return $company->findAll($criteria);
	}

	/**
	 * @static
	 * @param string $searchTerm
	 * @param string $sortBy
	 * @return \CDbCriteria|null
	 */
	public static function GetSearchCriteria($searchTerm, $sortBy = '')
	{
		$searchTerm = trim($searchTerm);
		if (empty($searchTerm))
		{
			return null;
		}
		$criteria = new \CDbCriteria();
		
		$criteria->condition = 't.Name LIKE :SearchTerm';
		$criteria->order = 't.Name DESC, t.CreationTime DESC';
		$criteria->params = array(':SearchTerm' => \Utils::PrepareStringForLike($searchTerm) . '%');
		return $criteria;
	}

  /**
   * @static
   * @param $name
   * @return array opf => правовая форма компании, name => название компании
   */
  public static function ParseName($name)
  {
    preg_match("/^([\'\"]*(ООО|ОАО|АО|ЗАО|ФГУП|ПКЦ|НОУ|НПФ|РОО|КБ|ИКЦ)?\s*,?\s+)?([\'\"]*)?([А-яЁёA-z0-9 \.\,\&\-\+\%\$\#\№\!\@\~\(\)]+)\3?([\'\"]*)?$/iu", $name, $matches);

    $opf = (isset($matches[2])) ? $matches[2] : '';
    $name = (isset($matches[4])) ? $matches[4] : '';

    return array(
      'opf' => $opf,
      'name' => $name
    );
  }

	/**
	 * @static
	 * @param bool $onServerDisc
	 * @return string
	 */
	public static function GetBaseDir($onServerDisc = false)
	{
		$result = \Yii::app()->params['CompanyLogoDir'];
		if ($onServerDisc)
		{
			$result = $_SERVER['DOCUMENT_ROOT'] . $result;
		}

		return $result;
	}

	/**
	* Возвращает путь к мини изображению компании
	* @param bool $onServerDisc
	* @return string
	*/
	public function GetMiniLogo($onServerDisc = false)
	{
		$id = $this->GetCompanyId();
		$result = $id . '_50.jpg';
		if ($onServerDisc || file_exists(self::GetBaseDir(true) . $result))
		{
			$result = self::GetBaseDir($onServerDisc) . $result;
		}
		else
		{
			$result = self::GetBaseDir($onServerDisc) . 'no_logo.png';
		}
		
		return $result;
	}  
	
	/**
	* Возвращает путь к изображению компании
	* @param bool $onServerDisc
	* @return string
	*/
	public function GetLogo($onServerDisc = false)
	{
		$id = $this->GetCompanyId();
		$result = $id . '_200.jpg';
		if ($onServerDisc || file_exists(self::GetBaseDir(true) . $result))
		{
			$result = self::GetBaseDir($onServerDisc) . $result;
		}
		else
		{
			$result = self::GetBaseDir($onServerDisc) . 'no_logo.png';
		}

		return $result;
	}

	// ID КОМПАНИИ
	public function GetCompanyId()
	{
		return $this->CompanyId;
	}
	
	public function SetCompanyId($value)
	{
		$this->CompanyId = $value;
	}

	// НАЗВАНИЕ КОМПАНИИ
	public function GetName()
	{
		return stripslashes($this->Name);
	}
	
	public function SetName($value)
	{
		$this->Name = $value;
	}

	// ПОЛНОЕ НАЗВАНИЕ КОМПАНИИ
	public function GetFullName()
	{
		return $this->FullName;
	}
	
	public function SetFullName($value)
	{
		$this->FullName = $value;
	}
	
	// ИНФОРМАЦИЯ О КОМПАНИИ
	public function GetInfo()
	{
		return $this->Info;
	}
	
	public function SetInfo($value)
	{
		$this->Info = $value;
	}
 
	// Организационно-правовая форма компании
	public function GetOpf()
	{
		return $this->Opf;
	}
	
	public function SetOpf($value)
	{
		$this->Opf = $value;
	}

	/**
	* @desc Сайт компании
	* 
	* @return array[ContactSite]
	*/
	public function GetSites()
	{
		return $this->Sites;
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
	* @desc E-mail компании
	* 
	* @return array[ContactEmail]
	*/
	public function GetEmails()
	{
		return $this->Emails;
	}

	/**
	* @desc Телефоны компании
	* 
	* @return \contact\models\Phone[]
	*/
	public function GetPhones()
	{
		return $this->Phones;
	}

	
	/**
	* @desc Адрес компании
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
	* @desc Аккаунты социального общения компании
	* 
	* @return array[ContactServiceAccount]
	*/
	public function GetServiceAccounts()
	{
		return $this->ServiceAccounts;
	}
	


	/**
	* Добавляет компании адрес электронной почты
	* 
	* @param \contact\models\Email $email
	*/
	public function AddEmail($email)
	{
		$db = \Yii::app()->getDb();
		$sql = 'INSERT INTO Link_Company_ContactEmail ( CompanyId , EmailId) VALUES (' . $this->CompanyId . ',' . $email->EmailId . ')';
		$db->createCommand($sql)->execute();
	}

	/**
	 * @param \contact\models\Site $site
	 * @return void
	 */
	public function AddSite($site)
	{
		$db = \Yii::app()->getDb();
		$sql = 'INSERT INTO Link_Company_ContactSite ( CompanyId , SiteId) VALUES (' . $this->CompanyId . ',' . $site->SiteId . ')';
		$db->createCommand($sql)->execute();
	}

	/**
	 * @param \contact\models\Address $address
	 * @return void
	 */
	public function AddAddress($address)
	{
		$db = \Yii::app()->getDb();
		$sql = 'INSERT INTO Link_Company_ContactAddress ( CompanyId , AddressId) VALUES (' . $this->CompanyId . ',' . $address->AddressId . ')';
		$db->createCommand($sql)->execute();
	}

	/**
	 * @param \contact\models\Phone $phone
	 * @return void
	 */
	public function AddPhone($phone)
	{
		$db = \Yii::app()->getDb();
		$sql = 'INSERT INTO Link_Company_ContactPhone ( CompanyId , PhoneId) VALUES (' . $this->CompanyId . ',' . $phone->PhoneId . ')';
		$db->createCommand($sql)->execute();
	}

	/**
	 * @param \contact\models\Site $site
	 * @return void
	 */
	public function DeleteSite($site)
	{
		if (is_object($site))
		{
			$site = $site->SiteId;
		}
		$db = \Yii::app()->getDb();
		$sql = 'DELETE FROM Link_Company_ContactSite WHERE CompanyId = ' . $this->CompanyId .' AND SiteId = ' . $site;
		$db->createCommand($sql)->execute();
	}

	/**
	 * @param \contact\models\Phone $phone
	 * @return void
	 */
	public function DeletePhone($phone)
	{
		if (is_object($phone))
		{
			$phone = $phone->PhoneId;
		}
		$db = \Yii::app()->getDb();
		$sql = 'DELETE FROM Link_Company_ContactPhone WHERE CompanyId = ' . $this->CompanyId .' AND PhoneId = ' . $phone;
		$db->createCommand($sql)->execute();
	}

	/**
	 * @param \contact\models\Email $email
	 * @return void
	 */
	public function DeleteEmail($email)
	{
		if (is_object($email))
		{
			$email = $email->EmailId;
		}
		$db = \Yii::app()->getDb();
		$sql = 'DELETE FROM Link_Company_ContactEmail WHERE CompanyId = ' . $this->CompanyId .' AND EmailId = ' . $email;
		$db->createCommand($sql)->execute();
	}

  /**
   * @param \user\models\User $user
   * @return void
   */
  public function AddEditor($user)
  {
    if (is_object($user))
    {
      $user = $user->UserId;
    }
    $editor = new Editor();
    $editor->UserId = $user;
    $editor->CompanyId = $this->CompanyId;
    $editor->save();
  }

  public function RemoveEditor($user)
  {
    if (is_object($user))
    {
      $user = $user->UserId;
    }
    Editor::RemoveByData($this->CompanyId, $user);
  }

  /**
   * @param \user\models\User $user
   * @return bool
   */
  public function IsEditor($user)
  {
    if (is_object($user))
    {
      $user = $user->UserId;
    }
    $editors = $this->Editors;
    foreach ($editors as $editor)
    {
      if ($editor->UserId == $user)
      {
        return true;
      }
    }
    return false;
  }

}