<?php
namespace partner\models\forms\user;

use user\models\User;

class Edit extends \CFormModel
{
    public $Label;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Label' => 'ФИО, RUNET-ID или Email участника'
        ];
    }

    public function rules()
    {
        return [
            ['Label', 'validateLabel']
        ];
    }

    public function validateLabel($attribute)
    {
        if (is_numeric($this->Label)) {
            $exists = User::model()->byRunetId($this->Label)->exists();
            if (!$exists) {
                $this->addError($attribute, 'Пользователь с таким RUNET-ID не найден.');
            }
        } else {
            $this->addError($attribute, 'Введите ФИО, RUNET-ID или Email участника и выберите его из списка для продолжения.');
        }
    }
}