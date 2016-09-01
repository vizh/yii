<?php
namespace competence\models\test\runet2016;

class E1_4 extends E1 {
    protected $prevCodes = ['16'=>'D2_16', '15'=>'D2_15', '14'=>'D2_14', '13'=>'D2_13'];

    public function getBaseQuestionCode()
    {
        return 'B1_4';
    }
}
