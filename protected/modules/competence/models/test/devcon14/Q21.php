<?php
namespace competence\models\test\devcon14;

class Q21 extends \competence\models\form\Multiple
{
    public function rules()
    {
        return [
            ['value', 'safe'],
            ['other', 'checkOtherValidator'],
        ];
    }
}
