<?php
namespace user\models\forms;

use application\components\form\CreateUpdateForm;
use application\components\utility\Texts;
use application\helpers\Flash;
use contact\models\forms\Address;
use CText;
use event\models\Event;
use event\models\Role;
use user\models\User;

/**
 * Class Register
 * @package user\models\forms
 *
 */
abstract class Register extends CreateUpdateForm
{
    /** @var User */
    protected $model;

    public $FirstName;
    public $LastName;
    public $FatherName;
    public $Password;
    public $Email;
    public $Company;
    public $Position;
    public $Phone;


    public function rules()
    {
        return [
            ['FirstName,LastName,FatherName,Company,Position', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['FirstName, LastName', 'required'],
            ['Email', 'required'],
            ['FatherName, Company, Position', 'safe'],
            ['Phone', 'filter', 'filter' => '\application\components\utility\Texts::getOnlyNumbers'],
            ['Phone', 'unique', 'className' => '\user\models\User', 'attributeName' => 'PrimaryPhone', 'criteria' => ['condition' => '"t"."Visible"']],
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
        if (!empty($this->Email) && !$this->isHiddenUser()) {
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
            'FirstName' => \Yii::t('app', 'Имя'),
            'LastName' =>  \Yii::t('app', 'Фамилия'),
            'FatherName' =>  \Yii::t('app', 'Отчество'),
            'Password' =>  \Yii::t('app', 'Пароль'),
            'Email' =>  \Yii::t('app', 'E-mail'),
            'Company' =>  \Yii::t('app', 'Компания'),
            'Position' =>  \Yii::t('app', 'Должность'),
            'Phone' =>  \Yii::t('app', 'Телефон'),
            'City' =>  \Yii::t('app', 'Город')
        ];
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
            $this->internalCreateActiveRecord();
            $transaction->commit();
            return $this->model;
        } catch (\CDbException $e) {
            $transaction->rollBack();
            Flash::setError($e);
        }
        return null;
    }

    /**
     *
     */
    protected function internalCreateActiveRecord()
    {
        $notify = !$this->isHiddenUser();

        $this->model = new User();
        $this->fillActiveRecord();
        $this->model->PrimaryPhone = $this->Phone;
        $this->model->register($notify);
        if ($this->isHiddenUser()) {
            $this->model->Visible = false;
            $this->model->save();
        }
        if (!empty($this->Company)) {
            $this->model->setEmployment($this->Company, $this->Position);
        }

    }

    /**
     * true - если требуется зарегистрировать скрытого пользователя
     * @return bool
     */
    protected function isHiddenUser()
    {
        return false;
    }
}
