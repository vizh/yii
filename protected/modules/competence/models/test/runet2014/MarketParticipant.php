<?php
namespace competence\models\test\runet2014;

use competence\models\Question;

trait MarketParticipant
{
    public function getIsMarketParticipant($test)
    {
        $codes = ['B3_1', 'B3_2', 'B3_3', 'B3_4', 'B3_5', 'B3_6', 'B3_7', 'B3_8', 'B3_9', 'B3_10', 'B3_11', 'B3_12', 'B3_13', 'B3_14', 'B3_15', 'B3_16'];
        foreach ($codes as $code) {
            $question = Question::model()->byCode($code)->byTestId($test->Id)->find();
            $question->Test = $test;
            $result = $question->Test->getResult()->getQuestionResult($question);
            if (!empty($result) && $result['value'] == 1) {
                return true;
            }
        }
        return false;
    }
} 