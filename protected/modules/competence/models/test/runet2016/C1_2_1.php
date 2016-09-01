<?php
namespace competence\models\test\runet2016;


class C1_2_1 extends C1
{
    protected $prevCodes = [ '1'=>'D2_1'];

    protected function getBaseQuestionCode()
    {
        return 'B1_1';
    }
}
