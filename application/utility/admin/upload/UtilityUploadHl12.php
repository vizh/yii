<?php
AutoLoader::Import('library.texts.*');
AutoLoader::Import('utility.source.*');
AutoLoader::Import('library.rocid.company.*');

class UtilityUploadHl12 extends AdminCommand
{
  const Path = '/files/';
  const FileName = 'hl2012_test.csv';
  const EventId = 385;

  private $roles = array(
    'Участник' => 1,
    'Докладчик' => 3,
    'ВИП' => 14,
    'Промо' => 34
  );

  /** @var Event */
  private $event = null;

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    return;
    $fieldMap = array(
      'FirstName' => 0,
      'LastName' => 1,
      'Company' => 2,
      'Role' => 3,
    );

    $this->event = Event::GetById(self::EventId);

    $parser = new CsvParser($_SERVER['DOCUMENT_ROOT'] . self::Path . self::FileName);
    $parser->SetInEncoding('utf-8');

    $results = $parser->Parse($fieldMap, true);

    foreach ($this->roles as $key => $value)
    {
      $this->roles[$key] = EventRoles::GetById($value);
    }

    foreach ($results as $info)
    {
      $this->registerUser($info);
    }

    echo 'DONE!!!';
  }

  private function registerUser($info)
  {
    $user = User::Register($this->getEmail(), substr(md5(microtime(true)), 0, 8), false);
    if (!empty($user))
    {
      $user->LastName = $info->LastName;
      $user->FirstName = $info->FirstName;
      $user->save();

      if (!empty($info->Company))
      {
        $company = Company::GetCompanyByName($info->Company);
        if (empty($company))
        {
          $company = new Company();
          $company->Name = $info->Company;
          $company->save();
        }

        $employment = new UserEmployment();
        $employment->UserId = $user->UserId;
        $employment->CompanyId = $company->CompanyId;
        $employment->Primary = 1;
        $employment->save();
      }


      $role = isset($this->roles[$info->Role]) ? $this->roles[$info->Role] : null;
      if (empty($role))
      {
        $this->printError($info);
        return;
      }
      $this->event->RegisterUser($user, $role);
    }
    else
    {
      $this->printError($info);
    }
  }

  private function getEmail()
  {
    $hash = substr(md5(mt_rand() . microtime(true)), 0, 8);
    return 'hl12+' . $hash . '@rocid.ru';
  }

  private function printError($info)
  {
    echo 'Error!!!<br>';
    print_r($info);
    echo '<br><br>';
  }
}
