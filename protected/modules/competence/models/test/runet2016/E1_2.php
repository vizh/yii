<?php
namespace competence\models\test\runet2016;

class E1_2 extends E1 {

    protected $prevCodes = ['8'=>'D1_8', '7'=>'D2_7', '6'=>'D1_6', '5'=>'C4_5'];

    public function getBaseQuestionCode()
    {
        return 'B1_2';
    }
}
