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
   * @param int $importId
   * @param bool $useAnd
   *
   * @return ImportUser
   */
  public function byImportId($importId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."ImportId" = :ImportId';
    $criteria->params = array('ImportId' => $importId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param bool $imported
   * @param bool $useAnd
   *
   * @return ImportUser
   */
  public function byImported($imported, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = ($imported ? '' : 'NOT ') . '"t"."Imported"';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param bool $error
   * @param bool $useAnd
   *
   * @return ImportUser
   */
  public function byError($error, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = ($error ? '' : 'NOT ') . '"t"."Error"';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param Import $import
   * @param array $roles
   *
   * @throws \partner\components\ImportException
   */
  public function parse($import, $roles)
  {
    $roleName = $this->Role !== null ? $this->Role : 0;
    $roleId = isset($roles[$roleName]) ? $roles[$roleName] : 0;

    /** @var $role \event\models\Role */
    $role = \event\models\Role::model()->findByPk($roleId);
    if (empty($role))
      throw new \partner\components\ImportException('Не найдена роль.');

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

    $this->Imported = true;
    $this->save();
  }

  /**
   *
   * @param Import $import
   *
   * @throws \partner\components\ImportException
   * @return \user\models\User
   */
  private function getUser($import)
  {
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
      if (empty($this->FirstName) || empty($this->LastName))
        throw new \partner\components\ImportException('Не заданы имя или фамилия участника.');

      $user = new \user\models\User();
      $user->FirstName = $this->FirstName;
      $user->LastName = $this->LastName;
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