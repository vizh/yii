<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 07.12.2015
 * Time: 15:24
 */

namespace user\models\forms\fields;

use application\components\form\FormModel;
use user\models\User;

/**
 * Class Email
 * @package user\models\forms\fields
 *
 * Редактирует Email пользователя
 */
class Email extends FormModel
{
    public $Email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['Email', 'required'],
            ['Email', 'email', 'allowEmpty' => true],
            ['Email', 'application\components\validators\InlineValidator', 'method' => [$this, 'validateEmail'], 'skipOnError' => true],
        ];
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function validateEmail($attribute)
    {
        $exists = User::model()->byEmail($this->Email)->byVisible(true)->exists();
        if ($exists) {
            $this->addError($attribute, 'Пользователь с таким Email уже существует в RUNET-ID');
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
            'Email' =>  \Yii::t('app', 'E-mail'),
        ];
    }
}