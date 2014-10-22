<?php
namespace competence\models\test\mailru2014;

class Q8_1 extends \competence\models\form\Multiple
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['value', 'validateValue']
        ]);
    }

    public function validateValue($attribute, $params)
    {
        if (count($this->value) > 5) {
            $this->addError($attribute, 'Можно выбрать не более 5 вариантов.');
        }
    }
}
