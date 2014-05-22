<?php
namespace competence\models\test\devcon14;

class Q15 extends \competence\models\form\Single
{
    public function rules()
    {
        return [
            ['value', 'required', 'message' => 'Выберите один ответ из списка'],
            ['other', 'safe'],
        ];
    }
}
