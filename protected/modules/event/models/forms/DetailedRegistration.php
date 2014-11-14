<?php
namespace event\models\forms;

use \contact\models\forms\Phone;
use \contact\models\forms\Address;
use user\models\User;

class DetailedRegistration extends \CFormModel
{
    const ScenarioShowEmployment = 'show-employment';

    private $user;

    public $Email;
    public $Password;

    public $LastName;
    public $FirstName;
    public $FatherName;

    public $Company;
    public $Position;

    public $PrimaryPhone;

    /** @var Address */
    public $Address;

    public $Birthday;

    public $Invite;

    /**
     * @var \CUploadedFile
     */
    public $photo;

    public function __construct(\user\models\User $user = null, $scenario = '')
    {
        $this->user = $user;
        parent::__construct($scenario);
    }

    /**
     * @param array $values
     * @param bool $safeOnly
     */
    public function setAttributes($values, $safeOnly = true)
    {
        if (!empty($values)) {
            foreach ($values as $attr => $value) {
                if ($this->isDisabled($attr)) {
                    unset($values[$attr]);
                }
            }
        }
        return parent::setAttributes($values, $safeOnly);
    }


    public function init()
    {
        parent::init();

        $this->Address = new Address(Address::ScenarioRequired);

        if ($this->user != null) {
            $this->LastName = $this->user->LastName;
            $this->FirstName = $this->user->FirstName;
            $this->FatherName = $this->user->FatherName;
            $this->Email = $this->user->Email;
            $this->PrimaryPhone = $this->user->PrimaryPhone;

            if ($this->user->getEmploymentPrimary() !== null) {
                $this->Company = $this->user->getEmploymentPrimary()->Company->Name;
                $this->Position = $this->user->getEmploymentPrimary()->Position;
            }

            if ($this->user->getContactAddress() !== null) {
                $this->Address->attributes = $this->user->getContactAddress()->getAttributes();
            }


            if ($this->user->Birthday !== null) {
                $this->Birthday = \Yii::app()->dateFormatter->format('dd.MM.yyyy', $this->user->Birthday);
            }
        }
    }


    public function rules()
    {
        return [
            ['Email, LastName, FirstName, Birthday', 'required'],
            ['Email', 'email'],
            ['Email', 'validateUniqueEmail'],
            ['PrimaryPhone', 'filter', 'filter' => '\application\components\utility\Texts::getOnlyNumbers'],
            ['PrimaryPhone', 'required'],
            ['PrimaryPhone', 'unique', 'className' => '\user\models\User', 'attributeName' => 'PrimaryPhone', 'criteria' => ($this->user !== null ? ['condition' => '"t"."Id" != :UserId', 'params' => ['UserId' => $this->user->Id]] : [])],
            ['Company, Position', 'required', 'on' => [self::ScenarioShowEmployment]],
            ['Password,FatherName', 'safe'],
            ['Birthday', 'date', 'format' => 'dd.MM.yyyy']
        ];
    }

    protected function beforeValidate()
    {
        $purifier = new \CHtmlPurifier();
        $purifier->options = [
            'HTML.AllowedElements' => []
        ];
        $attributes = $this->attributes;
        foreach ($this->attributes as $field => $value) {
            if ($field == 'Address')
                continue;
            $attributes[$field] = $purifier->purify($value);
        }
        $this->attributes = $attributes;
        return parent::beforeValidate();
    }

    public function afterValidate()
    {
        if (!$this->isDisabled('LinkAddress')) {
            $this->Address->attributes = \Yii::app()->getRequest()->getParam(get_class($this->Address));
            if (!$this->Address->validate()) {
                foreach ($this->Address->getErrors() as $messages) {
                    $this->addError('Address', $messages[0]);
                }
            }
        }
    }

    public function validateUniqueEmail($attribute, $params)
    {
        if (empty($this->$attribute) || $this->user !== null)
            return true;

        $value = trim($this->$attribute);
        $user = User::model()->byEmail($value)->byVisible(true)->find();
        if ($user === null)
            return true;
        else {
            $this->addError('Email', \Yii::t('app', 'Пользователь с таким email уже существует. {link} или укажите другой email.', ['{link}' => \CHtml::link(\Yii::t('app', 'Авторизуйтесь'), '#', ['id' => 'PromoLogin'])]));
        }
        return false;
    }

    /**
     * @return \user\models\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $attribute
     * @return bool
     */
    public function isDisabled($attribute)
    {
        if ($this->user === null)
            return false;

        return !empty($this->user->$attribute);
    }

    /**
     * @return string[]
     */
    public function attributeLabels()
    {
        return [
            'Email' => \Yii::t('app', 'Адрес электронной почты'),
            'Password' => \Yii::t('app', 'Пароль'),
            'LastName' => \Yii::t('app', 'Фамилия'),
            'FirstName' => \Yii::t('app', 'Имя'),
            'FatherName' => \Yii::t('app', 'Отчество'),
            'Company' => \Yii::t('app', 'Компания'),
            'Position' => \Yii::t('app', 'Должность'),
            'PrimaryPhone' => \Yii::t('app', 'Телефон'),
            'Address' => \Yii::t('app', 'Город'),
            'Birthday' => \Yii::t('app', 'Дата рождения'),
        ];
    }
} 