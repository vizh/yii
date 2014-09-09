<?php
namespace competence\models\test\runet2014;

use competence\models\Question;

class D7 extends \competence\models\form\Textarea
{
    use MarketParticipant;

    public function getPrev()
    {
        $test = $this->getQuestion()->getTest();
        $question = Question::model()->byCode('D2')->byTestId($test->Id)->find();
        $question->Test = $test;
        $result = $question->Test->getResult()->getQuestionResult($question);

        foreach ($result['value'] as $value) {
            if ($value !== 'not') {
                if (!$this->getIsMarketParticipant($this->getQuestion()->Test)) {
                    $question = Question::model()->byCode('D5')->byTestId($this->getQuestion()->TestId)->find();
                    $question->Test = $this->getQuestion()->getTest();
                    return $question;
                }
                return parent::getPrev();
            }
        }

        $question = Question::model()->byCode('D2')->byTestId($this->getQuestion()->TestId)->find();
        $question->Test = $this->getQuestion()->getTest();
        return $question;
    }

}
