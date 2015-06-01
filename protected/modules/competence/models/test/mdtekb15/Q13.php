<?php
namespace competence\models\test\mdtekb15;

class Q13 extends \competence\models\form\Multiple
{
    public function rules()
    {
        return [
            ['value', 'safe']
        ];
    }
}
