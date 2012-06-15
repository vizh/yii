<?php
AutoLoader::Import('library.texts.*');
AutoLoader::Import('utility.source.*');

class UtilityUpload extends AdminCommand
{
  const Path = '/files/event/';
  //const FileName = 'riw_main-24-10-2011-22-00-59 (1).csv';
  //const FileName = 'rocidstatus.csv';
  const FileName = 'spic.csv';
  const EventId = 258;

  private $counters = array('FindByRocid' => 0, 'NotFindByRocid' => 0, 'FindByName' => 0, 'Registered' => 0, 'NoEmail' => 0, 'NotValidEmail' => 0, 'NoName' => 0, 'DublicateEmail' => 0, 'OnEvent' => 0, 'NewInEvent' => 0, 'BadRole' => 0, 'ChangeRole' => 0);

  private $errorUsers = array();

  private $roleChanges = array('Участник профессиональной программы' => 'Участник проф. программы',
                               'Пресса' => 'СМИ',
                               'Партнер' => 'Партнёр',
                               'Организатор' => 'Оргкомитет');

  /**
   * @var EventRoles[]
   */
  private $roles;

  protected function doExecute()
  {
    return;
    $fieldMap = array(
      'RocId' => 1,

      'LastName' => 3,
      'FirstName' => 4,
      'FatherName' => 5,

      'Email' => 8,

      'Company' => 6,

      'Role' => 2,

    );

    $parser = new CsvParser($_SERVER['DOCUMENT_ROOT'] . self::Path . self::FileName);
    $parser->UseRuLocale();

    $result = $parser->Parse($fieldMap, true);

    foreach ($result as $user)
    {
      $user->Role = $this->fixRoleName($user->Role);

      $rocidUser = null;
      if (empty($user->RocId) && !empty($user->Email))
      {
        $rocidUser = $this->findUser($user);
        if (empty($rocidUser))
        {
          $rocidUser = $this->createUser($user);
          echo 'create new' . '<br>';
        }
      }
      elseif (!empty($user->RocId) && mb_strpos($user->RocId, 'mail') !== false)
      {
        $rocidUser = $this->findUser($user);
      }
      elseif (empty($user->RocId))
      {
        $rocidUser = $this->findUser($user);
      }
      elseif (!empty($user->RocId))
      {
        $rocidUser = User::GetByRocid($user->RocId);
      }

      if (!empty($rocidUser))
      {
        $this->registerOnEvent($rocidUser, $user);
      }
    }

    //print_r($result);
  }

  private function findUser($user)
  {
    $rocidUser = null;
    if (! empty($user->Email))
    {
      $rocidUser = User::GetByEmail($user->Email);
    }

    if (empty($rocidUser))
    {
      $criteria = new CDbCriteria();
      $criteria->condition = 't.LastName = :LastName AND t.FirstName = :FirstName';
      $criteria->params = array(':LastName' => $user->LastName, ':FirstName' => $user->FirstName);

      $users = User::model()->findAll($criteria);
      if (sizeof($users) == 1)
      {
        $rocidUser = $users[0];
      }
    }
    return $rocidUser;
  }

  private function createUser($user)
  {
    $rocidUser = User::Register($user->Email, Texts::GeneratePassword());
    if (!empty($rocidUser))
    {
      $rocidUser->LastName = $user->LastName;
      $rocidUser->FirstName = $user->FirstName;
      $rocidUser->FatherName = $user->FatherName;
      $rocidUser->Email = $user->Email;
      $rocidUser->save();

      $rocidUser->AddEmail($user->Email, 1, 1);
    }
    return $rocidUser;
  }

  /**
   * @param User $rocidUser
   * @param stdClass $user
   */
  private function registerOnEvent($rocidUser, $user)
  {
    $eventUser = $rocidUser->EventUsers(
      array(
      'condition' => 'EventUsers.EventId = :EventId',
      'params' => array(':EventId' => self::EventId)
      )
    );

    $roles = EventRoles::GetAll();
    $role = null;
    foreach ($roles as $tmpRole)
    {
      if ($tmpRole->Name == $user->Role)
      {
        $role = $tmpRole;
        break;
      }
    }

    if (empty($role))
    {
      return;
    }

    if (empty($eventUser))
    {
      $eventUser = new EventUser();
      $eventUser->EventId = self::EventId;
      $eventUser->UserId = $rocidUser->UserId;
      $eventUser->RoleId = $role->RoleId;
      $eventUser->CreationTime = $eventUser->UpdateTime = time();
      $eventUser->save();
      echo 'add role<br>';
    }
    else
    {
      $eventUser = $eventUser[0];
      if ($eventUser->EventRole->Priority < $role->Priority)
      {
        $eventUser->RoleId = $role->RoleId;
        $eventUser->UpdateTime = time();
        $eventUser->save();
        echo 'update role<br>';
      }
    }
  }

  private function fixRoleName($roleName)
  {
    if (mb_strpos($roleName, 'ОРГАНИЗАТОР', null, 'utf-8'))
    {
      return 'Оргкомитет';
    }
    elseif (mb_strpos($roleName, 'Докладчик', null, 'utf-8'))
    {
      return 'Докладчик';
    }
    elseif (mb_strpos($roleName, 'ПРЕССА', null, 'utf-8'))
    {
      return 'СМИ';
    }
    elseif (mb_strpos($roleName, 'Партнер', null, 'utf-8'))
    {
      return 'Партнёр';
    }
    elseif (mb_strpos($roleName, 'Бизнес УЧАСТНИК зелёный', null, 'utf-8'))
    {
      return 'Бизнес-участник';
    }
    elseif (mb_strpos($roleName, 'УЧАСТНИК серый', null, 'utf-8'))
    {
      return 'Участник';
    }
    elseif (mb_strpos($roleName, 'Виртуальный участник', null, 'utf-8'))
    {
      return 'Виртуальный участник';
    }

    return 'Виртуальный участник';
  }

  protected function doExecute2()
  {
    set_time_limit(0);
    if (Yii::app()->getRequest()->getIsPostRequest())
    {
      setlocale(LC_ALL, 'ru_RU.CP1251');

      $fullPath = Registry::GetVariable('PublicPath') . self::Path . self::FileName;
      if (file_exists($fullPath))
      {
        $i = 0;
        $flag = false;
        $file = fopen($fullPath, 'r');
        while (($data = fgetcsv($file, 0, ';')) !== false)
        {
          if (!$flag)
          {
            $flag = true;
            continue;
          }

          $userData = new UserParseData();

          $userData->RocId = $this->map['rocId'] !== null ? $data[$this->map['rocId']] : null;

          if ($this->map['fullname'] !== null)
          {
            $fullname = iconv('Windows-1251', 'utf-8', $data[$this->map['fullname']]);
            $names = preg_split('/ /', $fullname, -1, PREG_SPLIT_NO_EMPTY);
            $userData->LastName = isset($names[0])? $names[0] : null;
            $userData->FirstName = isset($names[1])? $names[1] : null;
            $userData->FatherName = isset($names[2])? $names[2] : null;
          }
          else
          {
            $userData->LastName = $this->map['lastname'] !== null ? iconv('Windows-1251', 'utf-8', $data[$this->map['lastname']]) : null;
            $userData->FirstName = $this->map['firstname'] !== null ? iconv('Windows-1251', 'utf-8', $data[$this->map['firstname']]) : null;
            $userData->FatherName = $this->map['fathername'] !== null ? iconv('Windows-1251', 'utf-8', $data[$this->map['fathername']]) : null;
          }

          $userData->Company = $this->map['company'] !== null ? iconv('Windows-1251', 'utf-8', $data[$this->map['company']]) : null;
          $userData->Position = $this->map['position'] !== null ? iconv('Windows-1251', 'utf-8', $data[$this->map['position']]) : null;

          $userData->City = $this->map['city'] !== null ? iconv('Windows-1251', 'utf-8', $data[$this->map['city']]) : null;

          $userData->RocId = $this->map['workphone'] !== null ? $data[$this->map['workphone']] : null;
          $userData->RocId = $this->map['faxphone'] !== null ? $data[$this->map['faxphone']] : null;
          $userData->RocId = $this->map['mobilephone'] !== null ? $data[$this->map['mobilephone']] : null;

          $userData->RocId = $this->map['email'] !== null ? $data[$this->map['email']] : null;
          $userData->RocId = $this->map['address'] !== null ? $data[$this->map['address']] : null;
          $userData->RocId = $this->map['site'] !== null ? $data[$this->map['site']] : null;

          $userData->RocId = $this->map['role'] !== null ? $data[$this->map['role']] : null;

          print_r($userData);
        }
        fclose($file);

      }
      else
      {
        echo 'File not found!';
      }
    }
    else
    {
      $this->view->FileName = self::FileName;
      echo $this->view;
    }
  }

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute1()
  {
    set_time_limit(0);
    if (Yii::app()->getRequest()->getIsPostRequest())
    {
      setlocale(LC_ALL, 'ru_RU.CP1251');
      $this->initRoles();

      $fullPath = Registry::GetVariable('PublicPath') . self::Path . self::FileName;
      if (file_exists($fullPath))
      {
        $i = 0;
        $flag = false;
        $file = fopen($fullPath, 'r');

//        $content = iconv('windows-1251', 'utf-8', file_get_contents($fullPath));
//        $file = fopen("php://memory", 'r+');
//        fputs($file, $content);
//        rewind($file);
        while (($data = fgetcsv($file, 0, ';')) !== false)
        {
          if (!$flag)
          {
            $flag = true;
            continue;
          }
          if (!empty($data[$this->map['rocID']]))
          {
            $this->checkUser($data);
          }
          else
          {
            $this->findOrCreateUser($data);
          }
          $i++;
        }
        echo '<br><br><br>lines: ' . $i;
        echo '<pre>';
        print_r($this->counters);
        print_r($this->errorUsers);
        echo '</pre>';
      }
      else
      {
        echo 'File not found!';
      }
    }
    else
    {
      $this->view->FileName = self::FileName;
      echo $this->view;
    }

    exit;
  }

  private function initRoles()
  {
    $this->roles = array();
    $roles = EventRoles::GetAll();
    foreach ($roles as $role)
    {
      $this->roles[trim($role->Name)] = $role;
    }
  }

  private function checkUser($data)
  {
    $rocId = intval($data[$this->map['rocID']]);
    $user = User::GetByRocid($rocId);
    if (! empty($user))
    {
      $this->counters['FindByRocid'] += 1;
      $this->checkUserRole($user, $data);
    }
    else
    {
      $this->counters['NotFindByRocid'] += 1;
      $this->addErrorUser('NotFindByRocid', $data);
    }
  }

  private function findOrCreateUser($data)
  {
    $lastname = iconv('Windows-1251', 'utf-8', trim($data[$this->map['lastname']]));
    $firstname = iconv('Windows-1251', 'utf-8', trim($data[$this->map['firstname']]));
    $fathername = iconv('Windows-1251', 'utf-8', trim($data[$this->map['fathername']]));
    $email = iconv('Windows-1251', 'utf-8', trim($data[$this->map['email']]));
    if (empty($lastname) || empty($firstname))
    {
      $this->counters['NoName'] += 1;
      $this->addErrorUser('NoName', $data);
      return;
    }
    $validator = new CEmailValidator();
    if (empty($email))
    {
      $this->counters['NoEmail'] += 1;
      return;
    }
    if (!$validator->validateValue($email))
    {
      $this->counters['NotValidEmail'] += 1;
      $this->addErrorUser('NotValidEmail', $data);
      return;
    }
    $company = trim($data[$this->map['company']]);
    $users = User::GetBySearch($lastname . ' ' . $firstname, 200);
    foreach ($users as $user)
    {
      $employment = $user->EmploymentPrimary();
      if ($user->Email === $email || (! empty($employment) && !empty($employment->Company) && mb_strtolower($employment->Company->Name, 'utf-8') === mb_strtolower($company, 'utf-8')))
      {
        $this->counters['FindByName'] += 1;
        $this->addErrorUser('FindByName', $data);
        $this->checkUserRole($user, $data);
        return;
      }
    }


    $user = User::Register($email, Texts::GeneratePassword());
    if (!empty($user))
    {
      $this->counters['Registered'] += 1;
      $this->addErrorUser('Registered', $data);
      $user->LastName = $lastname;
      $user->FirstName = $firstname;
      $user->FatherName = $fathername;
      $user->Email = $email;
      $user->save();

      $user->AddEmail($email, 1, 1);

      $phone = iconv('Windows-1251', 'utf-8', trim($data[$this->map['phone']]));
      if (!empty($phone))
      {
        $contactPhone = new ContactPhone();
        $contactPhone->Phone = $phone;
        $contactPhone->Type = ContactPhone::TypePersonal;
        $contactPhone->save();
        $user->AddPhone($contactPhone);
      }

      $companyName = iconv('Windows-1251', 'utf-8', trim($data[$this->map['company']]));

      if (! empty($companyName))
      {
        $company = Company::GetCompanyByName($companyName);
        if (empty($company))
        {
          $company = new Company();
          $company->Name = $companyName;
          $company->CreationTime = time();
          $company->save();
        }
        $position = iconv('Windows-1251', 'utf-8', trim($data[$this->map['position']]));
        $position = !empty($position) ? $position : 'Сотрудник';
        $userEmployment = new UserEmployment();
        $userEmployment->CompanyId = $company->CompanyId;
        $userEmployment->UserId = $user->UserId;
        $userEmployment->Position = $position;
        $userEmployment->Primary = 1;
        $userEmployment->save();
      }

      $this->checkUserRole($user, $data);
      return;
    }
    else
    {
      $this->counters['DublicateEmail'] += 1;
      $this->addErrorUser('DublicateEmail', $data);
    }
  }

  /**
   * @param User $user
   * @param array $data
   * @return void
   */
  private function checkUserRole($user, $data)
  {
    /** @var $eventUsers EventUser[] */
    $eventUsers = $user->EventUsers(array('on'=>'EventUsers.EventId = '.self::EventId, 'with' => array('EventRole')));

    $roleName = iconv('Windows-1251', 'utf-8', trim($data[$this->map['role']]));
    if (isset($this->roleChanges[$roleName]))
    {
      $roleName = $this->roleChanges[$roleName];
    }


    if (! isset($this->roles[$roleName]))
    {
      $this->counters['BadRole'] += 1;
      $this->addErrorUser('BadRole', $data);
      return;
    }

    if (!empty($eventUsers))
    {
      $eventUser = $eventUsers[0];
      if (empty($eventUser))
      {
        $this->addErrorUser('EmptyEventUser', $data);
        return;
      }
      if (empty($eventUser->EventRole))
      {
        $this->addErrorUser('EmptyEventRole', $data);
        return;
      }
      if ($roleName == 'Участник проф. программы' &&
          trim($eventUser->EventRole->Name) != $roleName &&
          $eventUser->EventRole->Priority < $this->roles[$roleName]->Priority)
      {
        $eventUser->RoleId = $this->roles[$roleName]->RoleId;
        $eventUser->UpdateTime = time();
        $eventUser->save();
        $this->counters['ChangeRole'] += 1;
        $this->addErrorUser('ChangeRole', $data);
      }
    }
    else
    {
      $eventUser = new EventUser();
      $eventUser->UserId = $user->UserId;
      $eventUser->EventId = self::EventId;
      $eventUser->RoleId = $this->roles[$roleName]->RoleId;
      $eventUser->CreationTime = $eventUser->UpdateTime = time();
      $eventUser->save();
      $this->counters['NewInEvent'] += 1;
      $this->addErrorUser('NewInEvent', $data);
    }

  }

  private function addErrorUser($key, $data)
  {
    $this->errorUsers[$key][] = array(iconv('Windows-1251', 'utf-8', $data[$this->map['rocID']]),
                                      iconv('Windows-1251', 'utf-8',$data[$this->map['lastname']]),
                                      iconv('Windows-1251', 'utf-8',$data[$this->map['firstname']]),
                                      iconv('Windows-1251', 'utf-8',$data[$this->map['fathername']]),
                                      iconv('Windows-1251', 'utf-8',$data[$this->map['company']]),
                                      iconv('Windows-1251', 'utf-8',$data[$this->map['position']]),
                                      iconv('Windows-1251', 'utf-8',$data[$this->map['phone']]),
                                      iconv('Windows-1251', 'utf-8',$data[$this->map['email']]),
                                      iconv('Windows-1251', 'utf-8',$data[$this->map['role']]));
  }
}
