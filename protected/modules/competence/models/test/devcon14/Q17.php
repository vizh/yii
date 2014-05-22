<?php
namespace competence\models\test\devcon14;

class Q17 extends \competence\models\form\Single
{
    public function rules()
    {
        return [
            ['value', 'safe'],
            ['other', 'checkOtherValidator'],
        ];
    }

    public function getOtherValidatorErrorMessage()
    {
        return 'Необходимо заполнить текстовое поле';
    }
}
