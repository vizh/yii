<?php
namespace competence\models\test\devcon14;

class Q20 extends \competence\models\form\Multiple
{
    public function rules()
    {
        return [
            ['value', 'safe'],
            ['other', 'checkOtherValidator'],
        ];
    }
}
