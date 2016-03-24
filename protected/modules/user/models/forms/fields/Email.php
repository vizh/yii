<?php
namespace user\models\forms\fields;

use application\components\form\FormModel;
use user\models\User;

/**
 * Class Email Редактирует Email пользователя
 */
class Email extends FormModel
{
    /**
     * @var string Email of the user
     */
    public $Email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['Email', 'required'],
            ['Email', 'email', 'allowEmpty' => true],
            [
                'Email',
                'application\components\validators\InlineValidator',
                'method' => [$this, 'validateEmail'],
                'skipOnError' => true
            ]
        ];
    }

    /**
     * Validates email
     * @param $attribute
     * @return bool
     */
    public function validateEmail($attribute)
    {
        if (User::model()->byEmail($this->Email)->byVisible(true)->exists()) {
            $this->addError($attribute, 'Пользователь с таким Email уже существует в RUNET-ID');
            return false;
        }

        return true;
    }

    /**
     * Validates email for unique
     * @return bool
     */
    public function validateEmailUnique()
    {
        if (User::model()->byEmail($this->Email)->exists()) {
            $this->addError('Email', 'Пользователь с таким Email уже существует в RUNET-ID');
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Email' => \Yii::t('app', 'E-mail'),
        ];
    }
}
