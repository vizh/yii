<?php
namespace competence\models\test\runet2016;


class C1_16 extends C1
{
    protected $prevCodes = ['15'=>'D2_15', '14'=>'D2_14', '13'=>'D2_13'];
    
    protected function getBaseQuestionCode()
    {
        return 'B1_4';
    }
}
