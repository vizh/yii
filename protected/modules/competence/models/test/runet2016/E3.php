<?php
namespace competence\models\test\runet2016;

use competence\models\form\Input;

class E3 extends Input {
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [
            'value', 'numerical',
            'integerOnly'=>true,
            'message' => 'Вводимое значение должно быть целым числом.',
            'min' => 0,
            'tooSmall' => 'Вводимое значение не может быть меньше нуля.'
        ];
        return $rules;
    }
}
