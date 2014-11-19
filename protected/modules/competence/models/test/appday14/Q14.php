<?php
namespace competence\models\test\appday14;

class Q14 extends \competence\models\form\Base
{
    public function rules()
    {
        return [
            ['value', 'required', 'message' => 'Необходимо ознакомиться с с информацией ниже ']
        ];
    }

}
