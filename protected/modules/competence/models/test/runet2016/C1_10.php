<?php
namespace competence\models\test\runet2016;


class C1_10 extends C1
{
    protected $prevCodes = ['9'=>'D2_9'];

    protected function getBaseQuestionCode()
    {
        return 'B1_3';
    }
}
