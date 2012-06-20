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

    $event = Event::GetById(self::EventId);

    if (empty($eventUser))
    {
      $event->RegisterUser($rocidUser, $role);
      echo 'add role<br>';
    }
    else
    {
      /** @var $eventUser EventUser */
      $eventUser = $eventUser[0];
      $result = $eventUser->UpdateRole($role);
      if ($result)
      {
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
}