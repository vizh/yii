<?php
namespace competence\models\test\runet2016;


class C1_11 extends C1
{
    protected $prevCodes = ['10'=>'D2_10', '9'=>'D2_9'];

    protected function getBaseQuestionCode()
    {
        return 'B1_3';
    }
}