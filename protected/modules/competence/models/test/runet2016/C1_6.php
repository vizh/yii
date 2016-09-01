<?php
namespace competence\models\test\runet2016;

class C1_6 extends C1
{
    protected $prevCodes = ['5'=>'C4_5'];

    protected function getBaseQuestionCode()
    {
        return 'B1_2';
    }
}
