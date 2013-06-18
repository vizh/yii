<?php
namespace partner\models;

/**
 * Class ImportUser
 * @package partner\models
 *
 * @property int $Id
 * @property int $ImportId
 * @property string $LastName
 * @property string $FirstName
 * @property string $FatherName
 * @property string $Email
 * @property string $Phone
 * @property string $Company
 * @property string $Position
 * @property string $Role
 *
 *
 * @property bool $Imported
 * @property bool $Error
 * @property string $ErrorMessage
 *
 */
class ImportUser extends \CActiveRecord
{
  /**
   * @static
   * @param string $className
   * @return ImportUser
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'PartnerImportUser';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return [
      'Import' => [self::BELONGS_TO, 'partner\models\Import', 'ImportId']
    ];
  }

  /**
   * @param Import $import
   * @param array $roles
   */
  public function parse($import, $roles)
  {
    $this->Imported = true;
    $roleId = isset($roles[$this->Role]) ? $roles[$this->Role] : 0;

    /** @var $role \event\models\Role */
    $role = \event\models\Role::model()->findByPk($roleId);
    if (empty($role))
    {
      $this->Error = true;
      $this->ErrorMessage = 'Не найдена роль.';
      $this->save();
      return;
    }

    $user = $this->getUser($import);

    $import->Event->skipOnRegister = $import->NotifyEvent;
    if (sizeof($import->Event->Parts) == 0)
    {
      $import->Event->RegisterUser($user, $role);
    }
    else
    {
      $import->Event->registerUserOnAllParts($user, $role);
    }

    $this->save();
  }

  /**
   *
   * @param Import $import
   *
   * @return \user\models\User
   */
  private function getUser($import)
  {
    $user = null;

    if (empty($this->Email) || ImportUser::model()->exists([
          'condition' => '"ImportId" = :ImportId AND "Imported" AND "Email" = :Email AND "Id" != :Id',
          'params' => ['ImportId' => $import->Id, 'Email' => $this->Email, 'Id' => $this->Id]
        ]))
    {
      $this->Email = 'nomail'.$import->EventId.'+'.substr(md5($this->FirstName . $this->LastName . $this->Company), 0, 8).'@runet-id.com';
    }
    $user = \user\models\User::model()->byEmail($this->Email)->find();

    if ($user === null)
    {
      $user = new \user\models\User();
      $user->FirstName = !empty($this->FirstName) ? $this->FirstName : '-';
      $user->LastName = !empty($this->LastName) ? $this->LastName : '-';
      $user->FatherName = $this->FatherName;
      $user->Email = strtolower($this->Email);
      $user->register($import->Notify);

      $user->Visible = $import->Visible;
      $user->save();
    }

    if (!empty($this->Company))
    {
      try
      {
        $user->setEmployment($this->Company, !empty($this->Position) ? $this->Position : '');
      }
      catch (\application\components\Exception $e)
      {
        $this->ErrorMessage = 'Не корректно задано название компании';
      }
    }

    if (!empty($this->Phone))
    {
      $user->setContactPhone($this->Phone);
    }

    return $user;
  }

  protected function beforeSave()
  {
    if ($this->getIsNewRecord())
    {
      $this->Email = mb_strtolower($this->Email, 'utf-8');
    }
    return parent::beforeSave();
  }


}