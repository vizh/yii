<?php
namespace competence\models\test\runet2016;

class E1_3 extends E1 {    

    protected $prevCodes = ['12_2'=>'D1_12_2', '12_1'=>'D1_12_1', '11'=>'D2_11', '10'=>'D2_10', '9'=>'D2_9'];

    public function getBaseQuestionCode()
    {
        return 'B1_3';
    }
}
