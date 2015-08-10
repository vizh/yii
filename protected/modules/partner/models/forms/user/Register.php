<?php
namespace partner\models\forms\user;

use application\components\form\CreateUpdateForm;
use application\components\utility\Texts;
use application\helpers\Flash;
use CText;
use event\models\Event;
use event\models\Role;
use user\models\User;

class Register extends CreateUpdateForm
{
    public $FirstName;
    public $LastName;
    public $FatherName;
    public $Password;
    public $Email;
    public $Company;
    public $Position;
    public $Phone;
    public $Role;
    public $Hidden;

    private $event;

    public function __construct(Event $event)
    {
        parent::__construct(null);
        $this->event = $event;
    }


    public function rules()
    {
        return [
            ['FirstName, LastName, Role', 'required'],
            ['FatherName, Company, Position, Hidden', 'safe'],
            ['Phone', 'filter', 'filter' => '\application\components\utility\Texts::getOnlyNumbers'],
            ['Phone', 'unique', 'className' => '\user\models\User', 'attributeName' => 'PrimaryPhone', 'criteria' => ['condition' => '"t"."Visible"']],
            ['Role', 'in', 'range' => array_keys($this->getRoleData())],
            ['Email', 'email', 'allowEmpty' => true],
            ['Email', 'validateEmail'],
            ['Position', 'validateEmployment']
        ];
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function validateEmail($attribute)
    {
        if (!empty($this->Email) && empty($this->Hidden)) {
            $exists = User::model()->byEmail($this->Email)->byVisible(true)->exists();
            if ($exists) {
                $this->addError($attribute, 'Пользователь с таким Email уже существует в RUNET-ID');
                return false;
            }
        }
        return true;
    }

    /**
     * @param $attribute
     * @param $params
     * @return bool
     */
    public function validateEmployment($attribute, $params)
    {
        if (!empty($this->Position) && empty($this->Company)) {
            $this->addError($attribute, 'Поле "'. $this->getAttributeLabel('Position') .'" не может быть заполнено без поля "'. $this->getAttributeLabel('Company') .'"');
            return false;
        }
        return true;
    }

    public function attributeLabels()
    {
        return [
            'FirstName' => 'Имя',
            'LastName' => 'Фамилия',
            'FatherName' => 'Отчество',
            'Password' => 'Пароль',
            'Email' => 'E-mail',
            'EmailRandom' => 'Сгенерировать случайный e-mail',
            'Company' => 'Компания',
            'Position' => 'Должность',
            'Phone' => 'Телефон',
            'City' => 'Город',
            'Role' => 'Роль',
            'Hidden' => 'Добавить, как скрытого пользователя',
        ];
    }

    /**
     * @return array
     */
    public function getRoleData()
    {
        return \CHtml::listData($this->event->getRoles(), 'Id', 'Title');
    }

    /**
     * @inheritdoc
     */
    public function createActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $notify = empty($this->Hidden);

            $this->model = new User();
            $this->fillActiveRecord();
            $this->model->PrimaryPhone = $this->Phone;
            if (empty($this->Email)) {
                $this->Email = CText::generateFakeEmail($this->event->Id);
                $notify = false;
            }
            $this->model->register($notify);
            if (!empty($this->Hidden)) {
                $this->model->Visible = false;
                $this->model->save();
            }

            if (!empty($this->Company)) {
                $this->model->setEmployment($this->Company, $this->Position);
            }

            $this->event->skipOnRegister = !$notify;
            $this->event->registerUser($this->model, Role::model()->findByPk($this->Role));

            $transaction->commit();
            return $this->model;
        } catch (\CDbException $e) {
            $transaction->rollBack();
            Flash::setError($e);
        }
        return null;
    }
}
