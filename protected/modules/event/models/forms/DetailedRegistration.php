<?php
namespace event\models\forms;

use \contact\models\forms\Phone;
use \contact\models\forms\Address;

class DetailedRegistration extends \CFormModel
{
    private $user;

    public $email;
    public $password;

    public $lastName;
    public $firstName;
    public $fatherName;

    public $company;
    public $position;

    /** @var Phone */
    public $phone;

    /** @var Address */
    public $address;


    public $birthday;
    public $birthPlace;
    public $passportSerial;
    public $passportNumber;

    /**
     * @var \CUploadedFile
     */
    public $photo;

    public function __construct(\user\models\User $user = null)
    {
        $this->user = $user;
        parent::__construct();
    }

    public function init()
    {
        parent::init();

        $this->address = new Address();
        $this->phone = new Phone(Phone::ScenarioOneFieldRequired);

        if ($this->user != null) {
            $this->lastName = $this->user->LastName;
            $this->firstName = $this->user->FirstName;
            $this->fatherName = $this->user->FatherName;
            $this->email = $this->user->Email;

            if ($this->user->getEmploymentPrimary() !== null) {
                $this->company = $this->user->getEmploymentPrimary()->Company->Name;
                $this->position = $this->user->getEmploymentPrimary()->Position;
            }

            if ($this->user->getContactAddress() !== null) {
                $this->address->attributes = $this->user->getContactAddress()->getAttributes();
            }

            if ($this->user->getContactPhone() != null) {
                $this->phone->attributes = [
                    'Id' => $this->user->getContactPhone()->Id,
                    'OriginalPhone' => $this->user->getContactPhone()->getWithoutFormatting()
                ];
            }

            if ($this->user->Birthday !== null) {
                $this->birthday = \Yii::app()->dateFormatter->format('dd.MM.yyyy', $this->user->Birthday);
            }
        }

        // Создаем директорию для фото
        $this->makePhotosPath();
        if (!$this->hasPhoto())
            $this->scenario = 'no-has-photo';
    }


    public function rules()
    {
        return [
            ['email, lastName, firstName, fatherName, company, position, birthday, birthPlace, passportSerial, passportNumber', 'required'],
            ['email', 'uniqueEmailValidate'],
            ['birthday', 'date', 'format' => 'dd.MM.yyyy'],
            ['password', 'safe'],
            ['photo', 'required', 'on' => 'no-has-photo', 'message' => 'Необходимо загрузить фотографию'],
            ['photo', 'file', 'types' => 'jpg, jpeg, png, gif, bmp', 'allowEmpty' => true]
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
            if ($field == 'address' || $field == 'phone')
                continue;
            $attributes[$field] = $purifier->purify($value);
        }
        $this->attributes = $attributes;
        return parent::beforeValidate();
    }

    public function afterValidate()
    {
        $this->address->attributes = \Yii::app()->getRequest()->getParam(get_class($this->address));
        if (!$this->address->validate()) {
            foreach ($this->address->getErrors() as $messages) {
                $this->addError('address', $messages[0]);
            }
        }
        else {
            if (empty($this->address->RegionId)) {
                $this->address->addError('CityLabel', 'Не задан город');
                $this->addError('address', 'Необходимо заполнить поле Город.');
            }
        }

        $this->phone->attributes = \Yii::app()->getRequest()->getParam(get_class($this->phone));
        if (!$this->phone->validate()) {
            foreach ($this->phone->getErrors() as $messages) {
                $this->addError('Phone', $messages[0]);
            }
        }
    }

    public function uniqueEmailValidate($attribute, $params)
    {
        if ($attribute !== 'email' || empty($this->$attribute) || $this->user !== null)
            return true;
        $value = trim($this->$attribute);
        $user = \user\models\User::model()->byEmail($value)->byVisible(true)->find();
        if ($user === null)
            return true;

        if (empty($this->password)) {
            $this->addError($attribute, 'Пользователь с таким Email уже существует. Для регистрации введите пароль или авторизуйтесь под своим аккаунтом.');
            $this->addError('password', '');
        } else {
            if ($user->checkLogin($this->password)) {
                $this->user = $user;
                return true;
            } else {
                $this->addError('password', 'Неправильно введен пароль.');
            }
        }

        return false;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function isDisabled($attribute)
    {
        if ($this->user === null)
            return false;
        $attribute = ucfirst($attribute);
        return !empty($this->user->$attribute);
    }

    /**
     * @param boolean $fullPath
     * @return string Путь к файлам фотографий
     */
    public function getPhotosPath($fullPath = true)
    {
        return ($fullPath ? \Yii::getPathOfAlias('webroot') : '').'/files/user/internetbusiness14/';
    }

    /**
     * Создает директорию с файлами фотографий
     * @throws \CException
     */
    private function makePhotosPath()
    {
        $photoPath = $this->getPhotosPath();
        if (!is_dir($photoPath))
            @mkdir($photoPath, 0777, true);
        if (!is_dir($photoPath))
            throw new \CException('Невозможно создать директорию: '.$photoPath);
    }

    /**
     * @return bool Имеется ли у пользователя фотография
     */
    public function hasPhoto()
    {
        if (!\Yii::app()->user->hasState('temp-photo-name'))
            return false;

        return file_exists($this->getPhotosPath().\Yii::app()->user->getState('temp-photo-name'));
    }

    /**
     * @return null|string Путь к фотографии
     */
    public function getPhotoUrl()
    {
        if (!\Yii::app()->user->hasState('temp-photo-name'))
            return null;

        return $this->getPhotosPath(false).\Yii::app()->user->getState('temp-photo-name');
    }

    /**
     * Сохраняет загруженный файл со временным именем
     * @return bool Удалось ли сохранить файл
     */
    public function saveTempPhoto()
    {
        if ($this->photo && $this->photo instanceof \CUploadedFile) {
            $tempName = md5($this->photo->getTempName().microtime()) . '.' . $this->photo->extensionName;
            $result = $this->photo->saveAs($this->getPhotosPath().$tempName);
            \Yii::app()->user->setState('temp-photo-name', $tempName);
            return $result;
        }
        return false;
    }

    /**
     * Сохраняет загруженный файл
     * @param \user\models\User $user
     * @return bool
     */
    public function savePhoto(\user\models\User $user)
    {
        $result = false;
        if (\Yii::app()->user->hasState('temp-photo-name')) {
            $tempName = \Yii::app()->user->getState('temp-photo-name');
            if (file_exists($this->getPhotosPath().$tempName)) {
                $pathParts = pathinfo($tempName);
                $result = copy($this->getPhotosPath().$tempName, $this->getPhotosPath().$user->Id.'.'.$pathParts['extension']);
                @unlink($this->getPhotosPath().$tempName);
            }
            \Yii::app()->user->setState('temp-photo-name', null);
        }
        elseif (!$result) {
            if ($this->photo && $this->photo instanceof \CUploadedFile)
                $result = $this->photo->saveAs($this->getPhotosPath().$user->Id.'.'.$this->photo->extensionName);
        }
        return $result;
    }

    /**
     * Чистит кеш и файл, если есть
     */
    public function clearTempPhoto()
    {
        if (!\Yii::app()->user->hasState('temp-photo-name'))
            return;

        $tempName = \Yii::app()->user->getState('temp-photo-name');
        if (file_exists($tempName)) {
            @unlink($this->getPhotosPath().$tempName);
        }
        \Yii::app()->user->setState('temp-photo-name', null);
    }


    public function attributeLabels()
    {
        return [
            'email' => \Yii::t('app', 'Адрес электронной почты'),
            'password' => \Yii::t('app', 'Пароль'),
            'lastName' => \Yii::t('app', 'Фамилия'),
            'firstName' => \Yii::t('app', 'Имя'),
            'fatherName' => \Yii::t('app', 'Отчество'),
            'company' => \Yii::t('app', 'Компания'),
            'position' => \Yii::t('app', 'Должность'),
            'phone' => \Yii::t('app', 'Телефон'),
            'address' => \Yii::t('app', 'Город'),
            'birthday' => \Yii::t('app', 'Дата рождения'),
            'birthPlace' => \Yii::t('app', 'Место рождения'),
            'passportSerial' => \Yii::t('app', 'Серия паспорта'),
            'passportNumber' => \Yii::t('app', 'Номер паспорта'),
        ];
    }
} 