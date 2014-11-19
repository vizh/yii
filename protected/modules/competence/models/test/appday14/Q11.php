<?php
namespace competence\models\test\appday14;

class Q11 extends \competence\models\form\Textarea
{
    public function rules()
    {
        return [
            ['value', 'safe']
        ];
    }

}
