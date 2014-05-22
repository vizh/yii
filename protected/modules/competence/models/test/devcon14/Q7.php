<?php
namespace competence\models\test\devcon14;

class Q7 extends \competence\models\form\Single
{
    public function rules()
    {
        return [
            ['value', 'safe'],
            ['other', 'checkOtherValidator'],
        ];
    }
}
