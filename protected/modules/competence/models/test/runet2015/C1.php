<?php
namespace competence\models\test\runet2015;

class C1 extends \competence\models\form\Input
{
    use MarketIndex;

    public function rules()
    {
        $rules = [];
        $rules[] = [
            'value', 'numerical',
            'message' => 'Вводимое значение должно быть числом, дробная часть отделяется точкой.',
            'min' => 0,
            'tooSmall' => 'Вводимое значение не может быть меньше нуля'
        ];
        return $rules;
    }
}