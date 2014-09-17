<?php
namespace competence\models\test\runet2014;

class C1 extends \competence\models\form\Input
{
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['value', 'numerical', 'message' => 'Вводимое значение должно быть числом, дробная часть отделяется точкой.'];
        return $rules;
    }
}