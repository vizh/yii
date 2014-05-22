<?php
namespace competence\models\test\devcon14;

class Q18 extends \competence\models\form\Single
{
    public function getOtherValidatorErrorMessage()
    {
        return 'Необходимо заполнить текстовое поле';
    }
}
