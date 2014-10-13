<?php
namespace partner\models;

use api\models\ExternalUser;
use pay\components\Exception;

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
 * @property string $Product
 * @property string $ExternalId
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
   * @param array $products
   *
   * @throws \partner\components\ImportException
   */
  public function parse($import, $roles, $products)
  {
    $roleName = $this->Role !== null ? $this->Role : 0;
    $roleId = isset($roles[$roleName]) ? $roles[$roleName] : 0;

    $role = \event\models\Role::model()->findByPk($roleId);
    if (empty($role))
      throw new \partner\components\ImportException('Не найдена роль.');

    $productName = $this->Product !== null ? $this->Product : 0;
    $productId = isset($products[$productName]) ? $products[$productName] : -1;

    $product = \pay\models\Product::model()->findByPk($productId);
    if ($productId != -1 && ($product == null || $product->EventId != $import->EventId))
      throw new \partner\components\ImportException('Не найден товар: "' . $productName . '".');

    $this->Email = $this->getCorrectEmail($import);
    $user = $this->getUser($import);

    $import->Event->skipOnRegister = !$import->NotifyEvent;
    if (sizeof($import->Event->Parts) == 0)
    {
      $import->Event->RegisterUser($user, $role);
    }
    else
    {
      $import->Event->registerUserOnAllParts($user, $role);
    }

    if ($product != null)
    {
        try {
            $orderItem = $product->getManager()->createOrderItem($user, $user);
            $orderItem->Paid = true;
            $orderItem->PaidTime = date('Y-m-d H:i:s');
            $orderItem->save();
        } catch (Exception $e) {}
    }

    $this->Imported = true;
    $this->save();
  }

  private function getCorrectEmail(Import $import)
  {
    $validator = new \CEmailValidator();
    $validator->allowEmpty = false;
    if (!$validator->validateValue($this->Email))
    {
      $this->Email = $this->generateEmail($import);
    }

    $criteria = new \CDbCriteria();
    $criteria->condition = '"ImportId" = :ImportId AND "Imported" AND "Email" = :Email AND "Id" != :Id';
    $criteria->params = [
      'ImportId' => $import->Id,
      'Email' => $this->Email,
      'Id' => $this->Id
    ];
    if (empty($this->Email) || ImportUser::model()->exists($criteria))
    {
      return $this->generateEmail($import);
    }

    $model = \user\models\User::model()->byEmail($this->Email)->byEventId($import->EventId);
    if ($import->Visible)
    {
      $model->byVisible(true);
    }
    $user = $model->find();
    if ($user != null && ($user->LastName != $this->LastName || $user->FirstName != $this->FirstName))
    {
      return $this->generateEmail($import);
    }
    return $this->Email;
  }

  private function generateEmail(Import $import)
  {
    return 'nomail'.$import->EventId.'+'.substr(md5($this->FirstName . $this->LastName . $this->Company), 0, 8).'@runet-id.com';
  }

  private function getUser(Import $import)
  {
    $user = $this->getDuplicateUser($import);
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

        if (!empty($this->ExternalId) && $import->getApiAccount() !== null) {
            $externalUser = new ExternalUser();
            $externalUser->UserId = $user->Id;
            $externalUser->AccountId = $import->getApiAccount()->Id;
            $externalUser->Partner = $import->getApiAccount()->Role;
            $externalUser->ExternalId = $this->ExternalId;
            $externalUser->save();
        }

      $this->setCompany($user);
    }
    $this->setPhone($user);
    return $user;
  }

  /**
   * @param Import $import
   * @return \user\models\User
   */
  private function getDuplicateUser($import)
  {
      if (!empty($this->ExternalId) && $import->getApiAccount() != null) {
          $externalUser = ExternalUser::model()
              ->byExternalId($this->ExternalId)->byAccountId($import->getApiAccount()->Id)->find();
          return $externalUser !== null ? $externalUser->User : null;
      }

    $model = \user\models\User::model()->byEmail($this->Email)->byEventId($import->EventId);
    if ($import->Visible)
    {
      $model->byVisible(true);
    }
    $user = $model->find();
    if ($user != null)
    {
      $this->setCompany($user);
    }
    else
    {
      $criteria = new \CDbCriteria();
      $criteria->with = ['Employments'];
      $criteria->addCondition('("Employments"."EndYear" IS NULL AND "Employments"."EndMonth" IS NULL)
        AND "Company"."Name" ILIKE :Company
        AND "t"."FirstName" ILIKE :FirstName AND "t"."LastName" ILIKE :LastName');
      $criteria->params = ['Company' => $this->Company, 'FirstName' => $this->FirstName, 'LastName' => $this->LastName];

      $model = \user\models\User::model();
      if ($import->Visible)
      {
        $model->byVisible(true);
      }
      else
      {
        $model->byEventId($import->EventId);
      }
      $user = $model->find($criteria);
    }
    return $user;
  }

  private function setCompany(\user\models\User $user)
  {
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
  }

  private function setPhone(\user\models\User $user)
  {
    if (!empty($this->Phone))
    {
      $user->setContactPhone($this->Phone);
    }
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