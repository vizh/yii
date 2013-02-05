<?php
namespace user\models;

/**
 * @throws \Exception
 *
 * @property int $Id
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
 *
 *
 *
 * @property LinkEmail $LinkEmail
 * @property LinkAddress $LinkAddress
 * @property LinkSite $LinkSite
 *
 * @property LinkPhone[] $LinkPhones
 * @property LinkServiceAccount[] $LinkServiceAccounts
 *
 *
 *
 *
 *
 *
 * @property \contact\models\Address[] $Addresses
 * @property \contact\models\Phone[] $Phones
 * @property \contact\models\Site[] $Sites
 * @property \contact\models\ServiceAccount[] $ServiceAccounts
 * @property \contact\models\Email[] $Emails
 *
 * @property \event\models\Participant[] $Participants
 * @property \event\models\Event[] $Events
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
class User extends \application\models\translation\ActiveRecord 
  implements \search\components\interfaces\ISearch
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
    return 'Id';
  }

  public function relations()
  {
    return array(
      'LinkEmail' => array(self::HAS_ONE, '\user\models\LinkEmail', 'UserId'),
      'LinkAddress' => array(self::HAS_ONE, '\user\models\LinkAddress', 'UserId'),
      'LinkSite' => array(self::HAS_ONE, '\user\models\LinkSite', 'UserId'),

      'LinkPhones' => array(self::HAS_MANY, '\user\models\LinkPhone', 'UserId'),
      'LinkServiceAccounts' => array(self::HAS_MANY, '\user\models\LinkServiceAccount', 'UserId'),


      'Employments' => array(self::HAS_MANY, '\user\models\Employment', 'UserId',
        'with' => 'Company',
        'order' => '"Employments"."Primary" DESC, "Employments"."EndYear" DESC, "Employments"."StartYear" DESC'
      ),




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

      'Settings' => array(self::HAS_ONE, '\user\models\Settings', 'UserId',),
      'Connects' => array(self::HAS_MANY, 'UserConnect', 'UserId'),
      //'InterestPersons' => array(self::HAS_MANY, 'UserInterestPerson', 'UserId', 'with' => array('InterestPerson')),
      'InterestPersons' => array(self::MANY_MANY, 'User', 'UserInterestPerson(UserId, InterestPersonId)'),
      'MobilePassword' => array(self::HAS_ONE, 'UserMobilePassword', 'UserId',),

      //Access
      'Groups' => array(self::MANY_MANY, 'CoreGroup', 'Core_Link_UserGroup(UserId, GroupId)', 'with' => array('Masks')),
    );
  }

  /**
   * @return string[]
   */
  public function getTranslationFields()
  {
    return array('LastName', 'FirstName', 'FatherName');
  }

  /**
   * @param int $runetId
   * @param bool $useAnd
   * @return User
   */
  public function byRunetId($runetId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."RunetId" = :RunetId';
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
    $criteria->condition = '"t"."Email" = :Email';
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
    $criteria->addCondition('"Participants"."EventId" = :EventId');
    $criteria->params['EventId'] = $eventId;
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * 
   * @return \user\models\User 
   */
  public function byVisible()
  {
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
    if ($locale === null || $locale == \Yii::app()->sourceLanguage)
    {
      $criteria = new \CDbCriteria();
      $size = sizeof($names);
      if ($size == 1)
      {
        $criteria->condition = '"t"."LastName" LIKE :Part0';
        $criteria->params = array(':Part0' => \Utils::PrepareStringForLike($names[0]) . '%');
      }
      elseif ($size == 2)
      {
        $criteria->condition = '("t"."LastName" LIKE :Part0 AND "t"."FirstName" LIKE :Part1 OR ' .
          '"t"."LastName" LIKE :Part1 AND "t"."FirstName" LIKE :Part0)';
        $criteria->params = array(':Part0' => \Utils::PrepareStringForLike($names[0]) . '%',
          ':Part1' => \Utils::PrepareStringForLike($names[1]) . '%');
      }
      else
      {
        $criteria->condition = '"t"."LastName" LIKE :Part0 AND "t"."FirstName" LIKE :Part1 AND ' .
          '"t"."FatherName" LIKE :Part2';
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
      return $this->byTranslationFields($locale, $fields);
    }
  }

  /**
   *
   * @return User
   */
  public function register()
  {
    if (empty($this->Password))
    {
      $this->Password = \Utils::GeneratePassword();
    }
    $password = $this->Password;
    $pbkdf2 = new \application\components\utility\Pbkdf2();
    $this->Password = $pbkdf2->createHash($password);
    $this->save();
    $this->refresh();

    $event = new \CModelEvent($this, array('password' => $password));
    $this->onRegister($event);

    return $this;
  }

  public function onRegister($event)
  {
    $this->raiseEvent('onRegister', $event);
  }

  /**
   * Проверяет пароль пользователя и обновляет хэш - если хэш старого образца
   * @param string $password
   * @return bool
   */
  public function checkLogin($password)
  {
    if (empty($this->Password))
    {
      $password2 = iconv('utf-8', 'Windows-1251', $password);
      $lightHash = md5($password);
      $lightHash2 = md5($password2);
      if ($this->OldPassword == $lightHash || $this->OldPassword == $lightHash2)
      {
        $pbkdf2 = new \application\components\utility\Pbkdf2();
        $this->Password = $pbkdf2->createHash($password);
        $this->OldPassword = null;
        $this->save();
        return true;
      }
      else
      {
        return false;
      }
    }
    else
    {
      return \application\components\utility\Pbkdf2::validatePassword($password, $this->Password);
    }
  }

  /** @var Photo */
  private $photo = null;
  /**
   * @return Photo
   */
  public function getPhoto()
  {
    if ($this->photo === null)
    {
      $this->photo = new Photo($this->RunetId);
    }
    return $this->photo;
  }


  /**
   * Добавляет пользователю адрес электронной почты
   *
   * @param string $email
   * @param bool $verified
   * @return \contact\models\Email
   */
  public function setContactEmail($email, $verified = false)
  {
    $contactEmail = $this->getContactEmail();
    if (empty($contactEmail))
    {
      $contactEmail = new \contact\models\Email();
      $contactEmail->Email = $email;
      $contactEmail->Verified = $verified;
      $contactEmail->save();

      $linkEmail = new LinkEmail();
      $linkEmail->UserId = $this->Id;
      $linkEmail->EmailId = $contactEmail->Id;
      $linkEmail->save();
    }
    elseif ($contactEmail->Email != $email)
    {
      $contactEmail->Email = $email;
      $contactEmail->Verified = $verified;
      $contactEmail->save();
    }

    return $contactEmail;
  }

  /**
   * @return \contact\models\Email|null
   */
  public function getContactEmail()
  {
    return !empty($this->LinkEmail) ? $this->LinkEmail->Email : null;
  }

  /**
   * @return \contact\models\Address|null
   */
  public function getContactAddress()
  {
    return !empty($this->LinkAddress) ? $this->LinkAddress->Address : null;
  }

  /**
   * Добавляет пользователю адрес электронной почты
   *
   * @param string $url
   * @param bool $secure
   * @return \contact\models\Site
   */
  public function setContactSite($url, $secure = false)
  {
    $contactSite = $this->getContactSite();
    if (empty($contactSite))
    {
      $contactSite = new \contact\models\Site();
      $contactSite->Url = $url;
      $contactSite->Secure = $secure;
      $contactSite->save();

      $linkSite = new LinkSite();
      $linkSite->UserId = $this->Id;
      $linkSite->SiteId = $contactSite->Id;
      $linkSite->save();
    }
    elseif ($contactSite->Url != $url || $contactSite->Secure != $secure)
    {
      $contactSite->Url = $url;
      $contactSite->Secure = $secure;
      $contactSite->save();
    }

    return $contactSite;
  }

  /**
   * @return \contact\models\Site|null
   */
  public function getContactSite()
  {
    return !empty($this->LinkSite) ? $this->LinkSite->Site : null;
  }

  /**
   * @param string $type
   * @return \contact\models\Phone|null
   */
  public function getContactPhone($type = \contact\models\PhoneType::Mobile)
  {
    foreach ($this->LinkPhones as $linkPhone)
    {
      if ($linkPhone->Phone->Type == $type)
      {
        return $linkPhone->Phone;
      }
    }
    return null;
  }


  /**
   * @param string $account
   * @param \contact\models\ServiceType $type
   * @return \contact\models\ServiceAccount
   */
  public function setContactServiceAccount($account, $type)
  {
    $serviceAccount = $this->getContactServiceAccount($type);
    if (empty($serviceAccount))
    {
      $serviceAccount = new \contact\models\ServiceAccount();
      $serviceAccount->TypeId = $type->Id;
      $serviceAccount->Account = $account;
      $serviceAccount->save();

      $linkServiceAccount = new LinkServiceAccount();
      $linkServiceAccount->UserId = $this->Id;
      $linkServiceAccount->ServiceAccountId = $serviceAccount->Id;
      $linkServiceAccount->save();
    }
    else
    {
      $serviceAccount->Account = $account;
      $serviceAccount->save();
    }

    return $serviceAccount;
  }

  /**
   * @param \contact\models\ServiceType $type
   * @return \contact\models\ServiceAccount|null
   */
  public function getContactServiceAccount($type)
  {
    foreach ($this->LinkServiceAccounts as $linkServiceAccount)
    {
      if ($linkServiceAccount->ServiceAccount->TypeId == $type->Id)
      {
        return $linkServiceAccount->ServiceAccount;
      }
    }
    return null;
  }

  /**
   * Возвращает основное место работы (либо последнее место работы, если по каким то причинам основное не указано)
   * @return Employment|null
   */
  public function getEmploymentPrimary()
  {
    return !empty($this->Employments) ? $this->Employments[0] : null;
  }

  /**
   * @return string
   */
  public function getFullName ()
  {
    $fullName = $this->getName();
    if ($this->getIsShowFatherName()) {
      $fullName .= ' '. $this->FatherName;
    }
    return $fullName;
  }

  /**
   * @return bool
   */
  public function getIsShowFatherName()
  {
    return !empty($this->FatherName) && ($this->Settings->HideFatherName == 0);
  }

  /**
   * @return string
   */
  public function getName()
  {
    return $this->LastName .' '. $this->FirstName;
  }


  /******  OLD METHODS  ***/
  /** todo: REWRITE ALL BOTTOM */

  /**
   * Обновляет последнее посещение пользователя
   * @return void
   */
  public function UpdateLastVisit()
  {
    $db = \Yii::app()->getDb();
    $db->createCommand()->update(self::$TableName, array('LastVisit' => time()), 'UserId = :UserId', array(':UserId' => $this->UserId));
  }

  public function Hide()
  {
    $this->Settings->Visible = 0;
    $this->Settings->save();
  }
  
  public function getAge()
  {
    if ($this->Birthday == null)
    {
      return 0;
    }
    $birthdayDate = new \DateTime($this->Birthday);
    return $birthdayDate->diff(new \DateTime())->y;
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