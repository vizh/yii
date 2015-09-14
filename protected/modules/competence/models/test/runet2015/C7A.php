<?php
namespace competence\models\test\runet2015;

use competence\models\form\Input;

class C7A extends Input
{
    public function rules()
    {
        return [
            ['value', 'numerical', 'message' => 'Вводимое значение должно быть числом', 'min' => 0, 'integerOnly' => true, 'tooSmall' => 'Вводимое значение не может быть меньше нуля', 'max' => 99999]
        ];
    }
}