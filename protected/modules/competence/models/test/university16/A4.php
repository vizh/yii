<?php
namespace competence\models\test\university16;

use competence\models\form\Multiple;

class A4 extends Multiple {
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['value', 'validateValue'];
        return $rules;
    }


    public function validateValue($attribute, $params)
    {
        $size = sizeof($this->$attribute);
        if ($size > 7) {
            $this->addError($attribute, 'Можно выбрать не более 7 ответов.');
        }
    }

    protected function getDefinedViewPath()
    {
        return 'competence.views.test.university16.a4';
    }
}
