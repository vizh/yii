<?php
namespace partner\models;

use api\models\ExternalUser;
use application\components\ActiveRecord;
use event\models\UserData;
use pay\components\Exception;
use partner\components\ImportException;
use pay\models\Product;
use user\models\User;
use event\models\Role;

/**
 * Class ImportUser
 *
 * @property int $Id
 * @property int $ImportId
 * @property string $LastName
 * @property string $FirstName
 * @property string $FatherName
 * @property string $LastName_en;
 * @property string $FirstName_en;
 * @property string $FatherName_en;
 * @property string $Email
 * @property string $Phone
 * @property string $Company
 * @property string $Company_en
 * @property string $Position
 * @property string $Role
 * @property string $Product
 * @property string $ExternalId
 * @property string $UserData
 * @property string $PhotoUrl
 * @property string $PhotoNameInPath
 *
 * @property bool $Imported
 * @property bool $Error
 * @property string $ErrorMessage
 *
 * @property Import $Import
 */
class ImportUser extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'PartnerImportUser';
    }

    /**
     * @inheritdoc
     */
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
     * @throws ImportException
     */
    public function parse($import, $roles, $products)
    {
        $roleName = $this->Role !== null ? $this->Role : 0;
        $roleId = isset($roles[$roleName]) ? $roles[$roleName] : 0;

        if (!$role = Role::model()->findByPk($roleId)) {
            throw new ImportException('Не найдена роль.');
        }

        $productName = $this->Product !== null ? $this->Product : 0;
        $productId = isset($products[$productName]) ? $products[$productName] : -1;

        $product = Product::model()->findByPk($productId);
        if ($productId != -1 && ($product == null || $product->EventId != $import->EventId)) {
            throw new ImportException('Не найден товар: "' . $productName . '".');
        }

        $this->Email = $this->getCorrectEmail($import);
        $user = $this->fetchUser($import);

        $import->Event->skipOnRegister = !$import->NotifyEvent;
        if (sizeof($import->Event->Parts) == 0) {
            $import->Event->RegisterUser($user, $role);
        } else {
            $import->Event->registerUserOnAllParts($user, $role);
        }

        if ($product) {
            try {
                $orderItem = $product->getManager()->createOrderItem($user, $user);
                $orderItem->Paid = true;
                $orderItem->PaidTime = date('Y-m-d H:i:s');
                $orderItem->save();
            } catch (Exception $e) {
            }
        }

        $this->Imported = true;
        $this->save();
    }

    /**
     * @param User $user
     * @return UserData|null
     */
    public function getUserData(User $user)
    {
        if (empty($this->UserData)) {
            return null;
        }

        $data = UserData::fetch($this->Import->EventId, $user);

        $manager = $data->getManager();
        foreach (json_decode($this->UserData, true) as $key => $value) {
            try {
                $manager->{$key} = $value;
            } catch (\application\components\Exception $e) {
            }
        }

        return $data;
    }

    protected function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->Email = mb_strtolower($this->Email, 'utf-8');
        }

        return parent::beforeSave();
    }

    private function getCorrectEmail(Import $import)
    {
        $validator = new \CEmailValidator();
        $validator->allowEmpty = false;

        if (!$validator->validateValue($this->Email))
            $this->Email = \CText::generateFakeEmail($import->EventId);

        $criteria = new \CDbCriteria();
        $criteria->condition = '"ImportId" = :ImportId AND "Imported" AND "Email" = :Email AND "Id" != :Id';
        $criteria->params = [
            'ImportId' => $import->Id,
            'Email' => $this->Email,
            'Id' => $this->Id
        ];

        if (empty($this->Email) || ImportUser::model()->exists($criteria))
            return \CText::generateFakeEmail($import->EventId);

        $model = User::model()->byEmail($this->Email)->byEventId($import->EventId);
        if ($import->Visible) {
            $model->byVisible(true);
        }
        $user = $model->find();

        if ($user != null && ($user->LastName != $this->LastName || $user->FirstName != $this->FirstName))
            return \CText::generateFakeEmail($import->EventId);

        return $this->Email;
    }

    /**
     * Fetches the user. It tries to find the user and create a new user if it fails.
     *
     * @param Import $import
     * @return User
     * @throws ImportException
     */
    private function fetchUser(Import $import)
    {
        if (!$user = $this->findDuplicateUser($import)) {
            $user = $this->createUser($import);

            if ($this->ExternalId && $import->getApiAccount()) {
                $externalUser = new ExternalUser();
                $externalUser->UserId = $user->Id;
                $externalUser->AccountId = $import->getApiAccount()->Id;
                $externalUser->Partner = $import->getApiAccount()->Role;
                $externalUser->ExternalId = $this->ExternalId;
                $externalUser->save();
            }

            $this->setCompany($user);
        }

        $this->setTranslations($user);

        $this->setPhone($user);
        $this->setUserData($user, $import);

        $this->importPhoto($user);

        return $user;
    }

    /**
     * Fetches photo if this is exists
     * @param User $user
     */
    private function importPhoto(User $user)
    {
        if (!$this->PhotoNameInPath) {
            return;
        }

        $fileName = \Yii::getPathOfAlias('webroot.files.import-photos') . DIRECTORY_SEPARATOR . $this->PhotoNameInPath;
        if (!file_exists($fileName)) {
            return;
        }

        $user->getPhoto()->save($fileName);
    }

    /**
     * @param Import $import
     * @return User
     */
    private function findDuplicateUser($import)
    {
        if ($this->ExternalId && $import->getApiAccount()) {
            $externalUser = ExternalUser::model()
                ->byExternalId($this->ExternalId)
                ->byAccountId($import->getApiAccount()->Id)
                ->find();

            if ($user = $externalUser ? $externalUser->User : null) {
                $this->setPrimaryCompanyNameTranslation($user);
            }

            return $user;
        }

        $model = User::model()->byEmail($this->Email)->byEventId($import->EventId);
        if ($import->Visible) {
            $model->byVisible(true);
        }

        if (!$user = $model->find()) {
            $criteria = new \CDbCriteria();
            $criteria->with = ['Employments'];
            $criteria->addCondition('("Employments"."EndYear" IS NULL AND "Employments"."EndMonth" IS NULL)
                AND "Company"."Name" ILIKE :Company
                AND "t"."FirstName" ILIKE :FirstName AND "t"."LastName" ILIKE :LastName');
            $criteria->params = [
                'Company' => $this->Company,
                'FirstName' => $this->FirstName,
                'LastName' => $this->LastName
            ];

            $model = User::model();
            if ($import->Visible) {
                $model->byVisible(true);
            } else {
                $model->byEventId($import->EventId);
            }

            $user = $model->find($criteria);

            $this->setPrimaryCompanyNameTranslation($user);
        } else {
            $this->setCompany($user);
        }

        return $user;
    }

    /**
     * @param User $user
     */
    private function setCompany(User $user)
    {
        if (!$this->Company) {
            return;
        }

        try {
            $user->setEmployment($this->Company, $this->Position ?: '');
            $this->setPrimaryCompanyNameTranslation($user);
        } catch (\application\components\Exception $e) {
            $this->ErrorMessage = 'Не корректно задано название компании';
        }
    }

    private function setPhone(User $user)
    {
        if ($this->Phone) {
            $user->setContactPhone($this->Phone);
        }
    }

    /**
     * @param User $user
     * @param Import $import
     * @throws ImportException
     */
    private function setUserData(User $user, Import $import)
    {
        if ($data = $this->getUserData($user)) {
            $data->UserId = $user->Id;
            $manager = $data->getManager();
            if (!$manager->validate()) {
                foreach ($manager->getErrors() as $attribute => $errors) {
                    throw new ImportException('Ошибка атрибута пользоватя "' . $attribute . '": ' . $errors[0]);
                }
            }

            $data->save();
        }
    }

    /**
     * Creates a new user
     *
     * @param Import $import
     * @return User
     * @throws ImportException
     */
    private function createUser(Import $import)
    {
        if (!$this->FirstName || !$this->LastName) {
            throw new ImportException('Не заданы имя или фамилия участника.');
        }

        $user = new User();
        $user->FirstName = $this->FirstName;
        $user->LastName = $this->LastName;
        $user->FatherName = $this->FatherName;
        $user->Email = strtolower($this->Email);
        $user->register($import->Notify);

        $user->Visible = $import->Visible;
        $user->save();

        return $user;
    }

    /**
     * Sets user's fields translations.
     *
     * @param User $user
     * @param string $locale
     */
    private function setTranslations(User $user, $locale = 'en')
    {
        $user->setLocale($locale);

        foreach (['FirstName', 'LastName', 'FatherName'] as $attribute) {
            if (!$value = $this->{$attribute . '_en'}) {
                continue;
            }

            $user->$attribute = $value;

            $user->save();
        }

        $user->resetLocale();
    }

    /**
     * Sets user's primary company name translation.
     *
     * @param User $user
     * @param string $locale
     */
    private function setPrimaryCompanyNameTranslation(User $user = null, $locale = 'en')
    {
        if (!$user || !$this->Company_en) {
            return;
        }

        $user->refresh();

        foreach ($user->Employments as $employment) {
            if ($employment->Primary == true) {
                $company = $employment->Company;

                $company->setLocale($locale);
                $company->Name = $this->Company_en;
                $company->save();
                $company->resetLocale();
            }
        }
    }
}
