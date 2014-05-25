<?php
namespace competence\models\test\devcon14;

class Q3 extends \competence\models\form\Single
{
    public function rules()
    {
        return [
            ['value', 'safe'],
            ['other', 'checkOtherValidator'],
        ];
    }
}
