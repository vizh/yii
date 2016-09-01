<?php
namespace competence\models\test\runet2016;

class E1_1 extends E1 {
    protected $prevCodes = ['4'=>'D2_4', '3_2'=>'D2_3_2', '3_1'=>'D2_3_1', '2_2'=>'D2_2_2', '2_1'=>'D2_2_1', '1'=>'D2_1'];

    public function getBaseQuestionCode()
    {
        return 'B1_1';
    }
}
