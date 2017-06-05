<?php
namespace partner\models\forms;

class OperatorGenerate extends \CFormModel
{
    public $Prefix;
    public $CountOperators;
    public $CountAdmins;

    public function rules()
    {
        return [
            ['Prefix', 'required'],
            ['CountOperators, CountAdmins', 'numerical'],
            ['CountOperators, CountAdmins', 'positiveValidator']
        ];
    }

    public function attributeLabels()
    {
        return [
            'Prefix' => 'Префикс для логина',
            'CountOperators' => 'Количество операторов',
            'CountAdmins' => 'Количество администраторов'
        ];
    }

    public function positiveValidator($attribute, $params)
    {
        if ($this->$attribute < 0) {
            $this->addError($attribute, 'Поле "'.$this->getAttributeLabel($attribute).'" не может быть отрицательным');
            return false;
        }

        return true;
    }
}
