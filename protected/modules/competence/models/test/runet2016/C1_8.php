<?php
namespace competence\models\test\runet2016;

class C1_8 extends C1
{
    protected $prevCodes = ['7'=>'D2_7', '6'=>'D1_6', '5'=>'C4_5'];
    
    protected function getBaseQuestionCode()
    {
        return 'B1_2';
    }
}
