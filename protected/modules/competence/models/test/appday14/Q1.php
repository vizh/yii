<?php
namespace competence\models\test\appday14;

class Q1 extends \competence\models\form\Multiple
{
    public function rules()
    {
        return [
            ['value', 'required', 'message' => 'Выберите один ответ из списка'],
            ['other', 'safe'],
        ];
    }
}
