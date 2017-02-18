<?php
namespace event\models\forms;

use application\components\auth\identity\RunetId;
use application\components\form\CreateUpdateForm;
use application\components\utility\Texts;
use contact\models\forms\Address;
use event\models\Event;
use event\models\Role;
use event\models\UserData;
use user\models\DocumentType;
use user\models\forms\document\BaseDocument;
use user\models\User;
use event\widgets\DetailedRegistration as DetailedRegistrationWidget;
use contact\models\Address as AddressModel;

/**
 * Class DetailedRegistration Widget renders detailed registration form with possibility to specify additional
 * attributes @see application\models\Definition
 *
 * @property User $model
 * @property Address $ContactAddress
 * @property BaseDocument $Document
 *
 */
class DetailedRegistration extends CreateUpdateForm
{
    public $registerVisibleUser = true;
    public $unsubscribeNewUser = false;

    /**
     * @var Event
     * */
    private $event;

    /**
     * @var DetailedRegistrationWidget
     */
    private $widget;

    /**
     * @var UserData|null Additional data for user registration
     */
    private $userData;

    /**
     * @var string[]
     */
    private $usedAttributes;

    /**
     * @var Role[]
     */
    private $usedRoles = [];

    /**
     * @param DetailedRegistrationWidget $widget
     * @param User $user
     */
    public function __construct(DetailedRegistrationWidget $widget, User $user = null)
    {
        $this->widget = $widget;
        $this->event  = $widget->getEvent();
        $this->initUsedAttributes();

        if (isset($this->widget->WidgetRegistrationSelectRoleIdList)) {
            $this->usedRoles = Role::model()->findAllByPk(explode(',', $this->widget->WidgetRegistrationSelectRoleIdList));
        }

        parent::__construct($user);
        $this->initUserData();
    }

    /**
     * Инициализирует атрибуты, с которыми будет работать форма
     */
    private function initUsedAttributes()
    {
        foreach (['Email', 'LastName', 'FirstName'] as $attribute) {
            $this->usedAttributes[$attribute] = null;
        }

        if (isset($this->widget->WidgetRegistrationShowFatherName) && $this->widget->WidgetRegistrationShowFatherName == 1) {
            $this->usedAttributes['FatherName'] = null;
        }

        if (isset($this->widget->WidgetRegistrationShowPhoto) && $this->widget->WidgetRegistrationShowPhoto == 1) {
            $this->usedAttributes['Photo'] = null;
        }

        if (isset($this->widget->WidgetRegistrationShowPhone) && $this->widget->WidgetRegistrationShowPhone == 1) {
            $this->usedAttributes['PrimaryPhone'] = null;
        }

        if (isset($this->widget->WidgetRegistrationShowBirthday) && $this->widget->WidgetRegistrationShowBirthday == 1) {
            $this->usedAttributes['Birthday'] = null;
        }

        if (isset($this->widget->WidgetRegistrationShowContactAddress) && $this->widget->WidgetRegistrationShowContactAddress == 1) {
            $this->usedAttributes['ContactAddress'] = new Address();
        }

        if (isset($this->widget->WidgetRegistrationShowEmployment) && $this->widget->WidgetRegistrationShowEmployment == 1) {
            $this->usedAttributes['Company'] = null;
            $this->usedAttributes['Position'] = null;
        }

        if (isset($this->widget->WidgetRegistrationShowDocument) && $this->widget->WidgetRegistrationShowDocument == 1) {
            $this->usedAttributes['Document'] = $this->getDocumentForm();
        }

        $this->reorderUsedAttributes();
    }

    /**
     * Reorders primary fields
     */
    private function reorderUsedAttributes()
    {
        if (!isset($this->widget->WidgetRegistrationPrimaryFieldsOrderJson)) {
            return;
        }

        $order = $this->widget->WidgetRegistrationPrimaryFieldsOrderJson;
        if (!$order) {
            return;
        }

        $order = \CJSON::decode($order);
        if (!$order || !is_array($order)) {
            return;
        }

        $usedAttributes = [];
        foreach ($order as $attribute) {
            if (array_key_exists($attribute, $this->usedAttributes)) {
                $usedAttributes[$attribute] = null;
                unset($this->usedAttributes[$attribute]);
            }
        }

        $usedAttributes += $this->usedAttributes;
        $this->usedAttributes = $usedAttributes;
    }

    /**
     * @return BaseDocument
     * @throws \Exception
     */
    private function getDocumentForm()
    {
        return DocumentType::findOne(1)->getForm();
    }

    /**
     * Инициализация дополнительных полей
     */
    private function initUserData()
    {
        $data = new UserData();
        $data->EventId = $this->event->Id;
        $definitions = $data->getManager()->getDefinitions();

        if (!empty($definitions)) {
            $this->userData = $data;
        }
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [];
        foreach ($this->getUsedAttributes() as $attribute) {
            switch ($attribute) {
                case 'Email':
                    $rules = array_merge($rules, [
                        [$attribute, 'required'],
                        [$attribute, 'email'],
                        [$attribute, 'validateUniqueEmail']
                    ]);
                    break;

                case 'LastName':
                case 'FirstName':
                    $rules[] = [$attribute, 'required'];
                    break;

                case 'FatherName':
                    $rules[] = [$attribute, 'safe'];
                    break;

                case 'ContactAddress':
                    $rules[] = [$attribute, 'application\components\validators\NestedFormValidator'];
                    break;

                case 'Company':
                    $rules = array_merge($rules, [
                        ['Company', 'required'],
                        ['Position', isset($this->widget->WidgetRegistrationPositionRequired) && $this->widget->WidgetRegistrationPositionRequired ? 'required' : 'safe']
                    ]);
                    break;

                case 'Photo':
                    $rules[] = ['Photo', 'file', 'types' => 'jpg, jpeg, gif, png', 'allowEmpty' => $this->isUpdateMode()];
                    break;

                case 'PrimaryPhone':
                    $rules = array_merge($rules, [
                        [$attribute, 'filter', 'filter' => 'application\components\utility\Texts::getOnlyNumbers'],
                        [$attribute, 'required'],
                        [$attribute, 'unique', 'className' => User::className(), 'attributeName' => 'PrimaryPhone',
                            'criteria' => !$this->isUpdateMode() ? ['condition' => '"t"."PrimaryPhoneVerify"'] : ['condition' => '"t"."PrimaryPhoneVerify" AND "t"."Id" != :Id', 'params' => ['Id' => $this->model->Id]]
                        ],
                    ]);
                    break;

                case 'Birthday':
                    $rules[] = ['Birthday', 'required'];
                    $rules[] = ['Birthday', 'date', 'format' => 'dd.MM.yyyy'];
                    break;

                case 'Document':
                    $rules[] = ['Document', 'application\components\validators\NestedFormValidator'];
                    break;
            }
        }

        return $rules;
    }

    /**
     * @inheritdoc
     */
    protected function beforeValidate()
    {
        $attributes = $this->getAttributes();

        foreach ($this->getAttributes() as $name => $value) {
            if (is_object($value))
                continue;
            $attributes[$name] = Texts::clear($value);
        }

        $this->setAttributes($attributes);

        return parent::beforeValidate();
    }

    /**
     * @param string $attribute
     * @return bool
     */
    public function validateRole($attribute)
    {
        $value = $this->$attribute;
        if (!empty($this->roleData) && !array_key_exists($value, $this->roleData)) {
            $this->addError($attribute, \Yii::t('app', 'Неверное значение для поля {field}.', ['{field}' => $this->getAttributeLabel($attribute)]));
            return false;
        }
        return true;
    }

    /**
     * Валидация email пользвателя на уникальность
     * @param string $attribute
     * @param $params
     * @return bool
     */
    public function validateUniqueEmail($attribute, $params)
    {
        $value = trim($this->$attribute);
        if (empty($value) || $this->isDisabled('Email')) {
            return true;
        }

        // Не проверяем существование посетителя, если регистрируем невидимых
        if ($this->registerVisibleUser === false) {
            return true;
        }

        $user = User::model()
            ->byEmail($value)
            ->byVisible(true)
            ->find();

        if ($user === null)
            return true;
        else {
            $this->addError('Email', \Yii::t('app', 'Пользователь с таким email уже существует. {link} или укажите другой email.', ['{link}' => \CHtml::link(\Yii::t('app', 'Авторизуйтесь'), '#', ['id' => 'PromoLogin'])]));
        }

        return false;
    }

    /**
     * @param string $attribute
     * @return bool
     */
    public function isDisabled($attribute)
    {
        if ($this->model === null || $this->model->getIsNewRecord())
            return false;

        return !empty($this->model->$attribute);
    }

    /**
     * @return string[]
     */
    public function attributeLabels()
    {
        return [
            'Email' => \Yii::t('app', 'Электронная почта'),
            'Password' => \Yii::t('app', 'Пароль'),
            'LastName' => \Yii::t('app', 'Фамилия'),
            'FirstName' => \Yii::t('app', 'Имя'),
            'FatherName' => \Yii::t('app', 'Отчество'),
            'Company' => isset($this->widget->WidgetRegistrationCompanyTitle) ? $this->widget->WidgetRegistrationCompanyTitle : \Yii::t('app', 'Компания'),
            'Position' => isset($this->widget->WidgetRegistrationPositionTitle) ? $this->widget->WidgetRegistrationPositionTitle : \Yii::t('app', 'Должность'),
            'PrimaryPhone' => \Yii::t('app', 'Телефон'),
            'Address' => \Yii::t('app', 'Город'),
            'Birthday' => \Yii::t('app', 'Дата рождения'),
            'RoleId' => \Yii::t('app', 'Статус участия'),
            'Photo' => \Yii::t('app', 'Фотография'),
            'ContactAddress' => \Yii::t('app', 'Город'),
            'Document' => \Yii::t('app', 'Паспортные данные'),
        ];
    }

    /**
     * @return array
     */
    public function getRoleData()
    {
        return \CHtml::listData($this->usedRoles, 'Id', 'Title');
    }

    /**
     * @return \string[]
     */
    public function getUsedAttributes()
    {
        return array_keys($this->usedAttributes);
    }

    /**
     * @param $name
     * @return string|void
     * @throws \CException
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->usedAttributes)) {
            return $this->usedAttributes[$name];
        }
        return parent::__get($name);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     * @throws \CException
     */
    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->usedAttributes)) {
            return $this->usedAttributes[$name] = $value;
        }
        return parent::__set($name, $value);
    }

    /**
     * @param null|array $names
     * @return array|\string[]
     */
    public function getAttributes($names = null)
    {
        return $this->usedAttributes;
    }

    /**
     * @return UserData
     */
    public function getUserData()
    {
        return $this->userData;
    }

    /**
     * @inheritdoc
     */
    public function fillFromPost()
    {
        parent::fillFromPost();
        if (in_array('Photo', $this->getUsedAttributes())) {
            $this->Photo = \CUploadedFile::getInstance($this, 'Photo');
        }

        if (in_array('ContactAddress', $this->getUsedAttributes())) {
            $this->ContactAddress->attributes = \Yii::app()->getRequest()->getParam(get_class($this->ContactAddress));
        }

        if (in_array('Document', $this->getUsedAttributes())) {
            $this->Document->fillFromPost();
        }

        if (!is_null($this->userData)) {
            $manager = $this->userData->getManager();
            foreach ($manager->getDefinitions() as $definition) {
                $manager->{$definition->name} = $definition->internalSetAttribute($manager);
            }
        }
    }

    /**
     * @return \CActiveRecord|null|void
     */
    public function createActiveRecord()
    {
        $this->model = new User();
        $this->model->LastName = $this->LastName;
        $this->model->FirstName = $this->FirstName;
        $this->model->Email = $this->Email;
        $this->model->Visible = $this->registerVisibleUser;
        if (in_array('Document', $this->getUsedAttributes())) {
            $this->Document->setUser($this->model);
        }

        return $this->updateActiveRecord();
    }


    /**
     * @return \CActiveRecord|null|void
     */
    public function updateActiveRecord()
    {
        $this->validate(null, false);
        if ($this->userData !== null) {
            $this->userData->getManager()->validate();
        }

        /** @var \CDbTransaction $transaction */
        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            if (!$this->hasErrors() && ($this->userData == null || !$this->userData->getManager()->hasErrors())) {
                if ($this->model->isNewRecord) {
                    $this->model->register($this->model->Visible);
                    if ($this->unsubscribeNewUser) {
                        $this->model->Settings->UnsubscribeAll = true;
                        $this->model->Settings->save();
                    }
                }

                if (in_array('Photo', $this->getUsedAttributes()) && $this->Photo !== null) {
                    $this->model->getPhoto()->SavePhoto($this->Photo);
                }

                if (in_array('FatherName', $this->getUsedAttributes())) {
                    $this->model->FatherName = $this->FatherName;
                }

                if (in_array('Birthday', $this->getUsedAttributes())) {
                    $this->model->Birthday = \Yii::app()->getDateFormatter()->format('yyyy-MM-dd', $this->Birthday);
                }

                if (in_array('PrimaryPhone', $this->getUsedAttributes()) && $this->model->PrimaryPhone != $this->PrimaryPhone) {
                    $this->model->PrimaryPhone = $this->PrimaryPhone;
                    $this->model->PrimaryPhoneVerify = false;
                }

                $this->model->save();

                if (in_array('Company', $this->getUsedAttributes())) {
                    $employment = $this->model->getEmploymentPrimary();
                    if ($employment === null || $employment->Position !== $this->Position || $employment->Company->Name !== $this->Company) {
                        $this->model->setEmployment($this->Company, $this->Position);
                    }
                }

                if (in_array('ContactAddress', $this->getUsedAttributes())) {
                    $address = $this->model->getContactAddress();
                    if ($address === null){
                        $address = new AddressModel();
                    }
                    $address->setAttributes($this->ContactAddress->getAttributes(), false);
                    $address->save();
                    $this->model->setContactAddress($address);
                }

                if (in_array('Document', $this->getUsedAttributes())) {
                    $this->Document->updateActiveRecord();
                }

                if ($this->userData !== null) {
                    $this->userData->UserId = $this->model->Id;
                    $this->userData->save();
                }

                if (\Yii::app()->getUser()->getIsGuest()) {
                    $identity = new RunetId($this->model->RunetId);
                    $identity->authenticate();
                    if ($identity->errorCode == \CUserIdentity::ERROR_NONE) {
                        \Yii::app()->getUser()->login($identity);
                    }
                }
                $transaction->commit();

                return $this->model;
            } elseif ($this->userData !== null) {
                $this->addErrors($this->userData->getManager()->getErrors());
            }
        } catch (\CDbException $e) {
            $transaction->rollBack();
            $this->addError('', $e->getMessage());
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    protected function loadData()
    {
        $result = parent::loadData();
        if ($result) {
            if (in_array('Birthday', $this->getUsedAttributes())) {
                $this->Birthday = !empty($this->model->Birthday) ? \Yii::app()->getDateFormatter()->format('dd.MM.yyyy', $this->model->Birthday) : null;
            }

            if (in_array('ContactAddress', $this->getUsedAttributes())) {
                $address = $this->model->getContactAddress();
                if ($address !== null) {
                    $this->ContactAddress->setAttributes($address->getAttributes($this->ContactAddress->getSafeAttributeNames()));
                }
            }

            if (in_array('Company', $this->getUsedAttributes())) {
                $employment = $this->model->getEmploymentPrimary();
                if ($employment !== null && $employment->Company !== null) {
                    $this->Company = $employment->Company->Name;
                    $this->Position = $employment->Position;
                }
            }

            if (in_array('Document', $this->getUsedAttributes())) {
                $this->Document->setUser($this->model);
            }
        }
        return $result;
    }
}
