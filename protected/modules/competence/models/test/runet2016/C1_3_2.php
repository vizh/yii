<?php
namespace competence\models\test\runet2016;


class C1_3_2 extends C1
{
    protected $prevCodes = ['3_1'=>'D2_3_1', '2_2'=>'D2_2_2', '2_1'=>'D2_2_1', '1'=>'D2_1'];
    
    protected function getBaseQuestionCode()
    {
        return 'B1_1';
    }
}
