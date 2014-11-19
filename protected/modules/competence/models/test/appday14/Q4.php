<?php
namespace competence\models\test\appday14;

class Q4 extends \competence\models\form\Multiple
{
    public function rules()
    {
        return [
            ['value', 'safe'],
            ['other', 'checkOtherValidator'],
        ];
    }
}
