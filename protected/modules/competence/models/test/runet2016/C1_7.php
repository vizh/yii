<?php
namespace competence\models\test\runet2016;

class C1_7 extends C1
{
    protected $prevCodes = ['6'=>'D1_6', '5'=>'C4_5'];
    
    protected function getBaseQuestionCode()
    {
        return 'B1_2';
    }
}
