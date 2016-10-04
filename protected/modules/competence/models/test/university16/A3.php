<?php
namespace competence\models\test\university16;

use competence\models\form\Multiple;

class A3 extends Multiple {

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['value', 'validateValue'];
        return $rules;
    }


    public function validateValue($attribute, $params)
    {
        $size = sizeof($this->$attribute);
        if ($size > 3) {
            $this->addError($attribute, 'Можно выбрать не более 3 ответов.');
        }
    }
}
