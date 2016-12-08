<?php
namespace user\models\forms\admin;

use application\components\form\CreateUpdateForm;
use application\components\utility\Texts;
use application\helpers\Flash;
use contact\models\forms\Address;
use contact\models\forms\Phone;
use CText;
use user\models\forms\edit\Contacts;
use user\models\forms\edit\Employments;
use user\models\forms\Employment;
use user\models\LinkPhone;
use user\models\User as UserModel;
use contact\models\Address as AddressModel;
use contact\models\Phone as PhoneModel;
use user\models\Employment as EmploymentModel;

/**
 * Class User
 * @package user\models\forms\admin
 *
 * @property UserModel $model
 */
class User extends CreateUpdateForm
{
    public $RunetId;
    public $FirstName;
    public $LastName;
    public $FatherName;
    public $Email;
    public $Phones = [];
    public $Address;
    public $Visible = true;
    public $Subscribe = true;
    public $NewPassword;
    public $Photo;
    public $DeletePhoto;
    public $Employments = [];
    public $PrimaryPhone;

    /** @var Contacts */
    private $formContacts;

    /** @var Employment */
    private $formEmployments;

    public function __construct(UserModel $model = null)
    {
        $this->Address = new Address();
        $this->formContacts = new Contacts();
        $this->formEmployments = new Employments();
        parent::__construct($model);
    }


    public function rules()
    {
        return [
            ['FatherName, DeletePhoto', 'safe'],
            ['Visible, Subscribe', 'boolean'],
            ['Email', 'email', 'allowEmpty' => !$this->isUpdateMode()],
            ['Email', 'unique', 'className' => '\user\models\User', 'attributeName' => 'Email', 'caseSensitive' => false,
                'criteria' => ['condition' => '"t"."Id" != :UserId AND "t"."Visible"', 'params' => ['UserId' => $this->isUpdateMode() ? $this->model->Id : 0]]
            ],
            ['RunetId', 'numerical', 'integerOnly' => true],
            ['RunetId', 'numerical', 'max' => UserModel::model()->orderBy(['"t"."RunetId"' => SORT_DESC])->find()->RunetId, 'skipOnError' => true],
            ['RunetId', 'unique', 'className' => '\user\models\User', 'attributeName' => 'RunetId',
                'criteria' => ['condition' => '"t"."Id" != :UserId ', 'params' => ['UserId' => $this->isUpdateMode() ? $this->model->Id : 0]]
            ],
            ['FirstName, LastName', 'validateLocaleField'],
            ['NewPassword', 'length', 'min' => \Yii::app()->params['UserPasswordMinLenght'], 'allowEmpty' => true],
            ['PrimaryPhone', 'filter', 'filter' => '\application\components\utility\Texts::getOnlyNumbers'],
            ['PrimaryPhone', 'unique', 'className' => '\user\models\User', 'attributeName' => 'PrimaryPhone', 'criteria' => [
                'condition' => '"t"."Id" != :UserId AND "t"."Visible"', 'params' => ['UserId' => $this->isUpdateMode() ? $this->model->Id : 0]]
            ],
            ['Employments, Phones', '\application\components\validators\MultipleFormValidator'],
            ['Photo', 'file', 'types' => 'jpg, jpeg, gif, png', 'allowEmpty' => true]
        ];
    }

    private $attributeLabels = null;

    /**
     * @return array|mixed
     */
    public function attributeLabels()
    {
        if ($this->attributeLabels == null) {
            $this->attributeLabels = [
                'Visible' => \Yii::t('app', 'Видимый'),
                'Subscribe' => \Yii::t('app', 'Получать рассылки'),
                'NewPassword' => $this->isUpdateMode() ? \Yii::t('app', 'Новый пароль') : \Yii::t('app', 'Пароль'),
                'FirstName' => \Yii::t('app', 'Имя'),
                'LastName' => \Yii::t('app', 'Фамилия'),
                'FatherName' => \Yii::t('app', 'Отчество'),
                'Employments' => \Yii::t('app', 'Места работы'),
                'Photo' => \Yii::t('app', 'Фотография'),
                'DeletePhoto' => \Yii::t('app', 'Удалить'),
                'RunetId' => 'RUNET&ndash;ID'
            ];
            $this->attributeLabels = array_merge($this->formContacts->attributeLabels(), $this->attributeLabels);
            $this->attributeLabels = array_merge($this->formEmployments->attributeLabels(), $this->attributeLabels);
        }
        return $this->attributeLabels;
    }

    /**
     * @param null $attributes
     * @param bool $clearErrors
     * @return bool
     */
    public function validate($attributes = null, $clearErrors = true)
    {
        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        $this->Address->attributes = $request->getParam(get_class($this->Address));
        if (!$this->Address->validate()) {
            foreach ($this->Address->getErrors() as $messages) {
                $this->addError('Address', $messages[0]);
            }
        }
        return parent::validate($attributes, false);
    }


    /**
     * @param array $values
     * @param bool $safeOnly
     */
    public function setAttributes($values, $safeOnly = true)
    {
        if (isset($values['Employments'])) {
            $this->Employments = [];
            foreach ($values['Employments'] as $value) {
                $form = new Employment();
                $form->attributes = $value;
                $this->Employments[] = $form;
            }
            unset($values['Employments']);
        }

        if (isset($values['Phones'])) {
            $this->Phones = [];
            foreach ($values['Phones'] as $value) {
                $form = new Phone(Phone::ScenarioOneFieldRequired);
                $form->attributes = $value;
                $this->Phones[] = $form;
            }
            unset($values['Phones']);
        }
        parent::setAttributes($values, $safeOnly);
    }

    /**
     * @param string $attribute
     * @return bool
     */
    public function validateLocaleField($attribute)
    {
        $value = $this->$attribute;
        if (empty($value[\Yii::app()->getLanguage()])) {
            $this->addError($attribute, \Yii::t('app', 'Не заполнено поле {field}.', ['{field}' => $this->getAttributeLabel($attribute)]));
            return false;
        }
        return true;
    }

    /**
     * @return array
     */
    public function getPhoneTypeData()
    {
        return $this->formContacts->getPhoneTypeData();
    }

    /**
     * @return string
     */
    public function getEmploymentsMonthOptions()
    {
        return $this->formEmployments->getMonthOptions();
    }

    /**
     * @return string
     */
    public function getEmploymentsYearOptions()
    {
        return $this->formEmployments->getYearOptions();
    }

    /**
     * @return mixed
     */
    public function getLocaleList()
    {
        return \Yii::app()->params['Languages'];
    }

    public function fillFromPost()
    {
        parent::fillFromPost();
        $this->Photo = \CUploadedFile::getInstance($this, 'Photo');
    }


    /**
     * @return bool
     */
    protected function loadData()
    {
        if (parent::loadData()) {
            $this->FirstName  = [];
            $this->LastName   = [];
            $this->FatherName = [];
            foreach ($this->getLocaleList() as $locale) {
                $this->model->setReturnTransliteIfEmpty(false);
                $this->model->setLocale($locale);
                foreach (['FirstName', 'LastName', 'FatherName'] as $attr) {
                    $this->{$attr}[$locale] = $this->model->$attr;
                }
                $this->model->resetLocale();

            }
            $address = $this->model->getContactAddress();
            if ($address !== null) {
                $this->Address->setAttributes($address->getAttributes($this->Address->getSafeAttributeNames()));
            }

            foreach ($this->model->LinkPhones as $link) {
                $form = new Phone(Phone::ScenarioOneFieldRequired);
                $form->attributes = [
                    'Id' => $link->PhoneId,
                    'OriginalPhone' => $link->Phone->getWithoutFormatting(),
                    'Type' => $link->Phone->Type
                ];
                $this->Phones[] = $form;
            }

            foreach ($this->model->Employments as $employment) {
                $form = new Employment();
                $form->attributes = [
                    'Id' => $employment->Id,
                    'Company' => (!empty($employment->Company->FullName) ? $employment->Company->FullName : $employment->Company->Name),
                    'Position' => $employment->Position,
                    'StartMonth' => $employment->StartMonth,
                    'StartYear' => $employment->StartYear,
                    'EndMonth' => $employment->EndMonth,
                    'EndYear' => $employment->EndYear,
                    'Primary' => $employment->Primary ? 1 : 0
                ];
                $this->Employments[] = $form;
            }
            $this->Subscribe = !$this->model->Settings->UnsubscribeAll;
        }
    }

    /**
     * @return \CActiveRecord|null
     */
    public function createActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $this->model = new UserModel();
            $this->fillActiveRecord();
            $this->model->Password = !empty($this->NewPassword) ? $this->NewPassword : Texts::GeneratePassword(\Yii::app()->params['UserPasswordMinLenght']);

            $notify = true;
            if (empty($this->model->Email)) {
                $this->model->Email = CText::generateFakeEmail();
                $notify = false;
            }

            $this->model->register($notify);
            $this->fillActiveRecordRelations();
            $transaction->commit();
            return $this->model;
        } catch (\CDbException $e) {
            $transaction->rollback();
            Flash::setError($e);
        }
    }

    /**
     * @return null|UserModel
     * @throws \CDbException
     * @throws \CHttpException
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        /** @var \CDbTransaction $transaction */
        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $this->fillActiveRecord();
            $this->model->save();
            $this->fillActiveRecordRelations();

            if (!empty($this->NewPassword)) {
                $this->model->changePassword($this->NewPassword);
            }

            if ($this->DeletePhoto == 1) {
                $this->model->getPhoto()->delete();
            }
            $transaction->commit();
            return $this->model;
        } catch (\CDbException $e) {
            $transaction->rollback();
            Flash::setError($e);
        }
        return null;
    }

    /**
     * @throws \CHttpException
     */
    public function fillActiveRecordRelations()
    {
        $this->model->Settings->UnsubscribeAll = !(bool)$this->Subscribe;
        $this->model->Settings->save();
        if ($this->Photo !== null) {
            $this->model->getPhoto()->SavePhoto($this->Photo);
        }
        $address = $this->model->getContactAddress();
        if ($address == null) {
            $address = new AddressModel();
        }
        $address->setAttributes($this->Address->getAttributes(), false);
        $address->save();
        $this->model->setContactAddress($address);

        $this->createUpdatePhones();
        $this->createUpdateEmployments();
    }

    /**
     * @inheritdoc
     */
    protected function fillActiveRecord()
    {
        if (parent::fillActiveRecord()) {
            foreach ($this->getLocaleList() as $locale) {
                $this->model->setLocale($locale);
                foreach (['FirstName', 'LastName', 'FatherName'] as $attr) {
                    $this->model->$attr = !empty($this->{$attr}[$locale]) ? $this->{$attr}[$locale] : '';
                }
            }
            $this->model->resetLocale();
            return true;
        }
        return false;
    }


    private function createUpdatePhones()
    {
        foreach ($this->Phones as $form) {
            if (!empty($form->Id)) {
                $link = LinkPhone::model()->byUserId($this->model->Id)->byPhoneId($form->Id)->find();
                if ($link === null) {
                    throw new \CHttpException(500);
                }
                $phone = $link->Phone;
                if ($form->Delete == 1) {
                    $link->delete();
                    $phone->delete();
                    continue;
                }
            } else {
                $link = new LinkPhone();
                $link->UserId = $this->model->Id;
                $phone = new PhoneModel();
            }

            $phone->CountryCode = $form->CountryCode;
            $phone->CityCode = $form->CityCode;
            $phone->Phone = $form->Phone;
            $phone->Type = $form->Type;
            $phone->save();
            $link->PhoneId = $phone->Id;
            $link->save();
        }
    }

    private function createUpdateEmployments()
    {
        foreach ($this->Employments as $form) {
            if (!empty($form->Id)) {
                $employment = EmploymentModel::model()->with(['Company'])->byUserId($this->model->Id)->findByPk($form->Id);
                if ($employment == null) {
                    throw new \CHttpException(500);
                }

                if ($form->Company !== $employment->Company->Name) {
                    $employment->chageCompany($form->Company);
                }
            } else {
                $employment = $this->model->setEmployment($form->Company, $form->Position);
            }

            if ($form->Delete == 1) {
                $employment->delete();
            } else {
                $employment->Position = $form->Position;
                $employment->StartMonth = !empty($form->StartMonth) ? $form->StartMonth : null;
                $employment->EndMonth = !empty($form->EndMonth) ? $form->EndMonth : null;
                $employment->StartYear = !empty($form->StartYear) ? $form->StartYear : null;
                $employment->EndYear = !empty($form->EndYear) ? $form->EndYear : null;
                $employment->Primary = $form->Primary == 1 && empty($form->EndYear) ? true : false;
                $employment->save();
            }
        }
        \Yii::app()->getDb()->createCommand('SELECT "UpdateEmploymentPrimary"(:UserId)')->execute([
            'UserId' => $this->model->Id
        ]);
    }
}
