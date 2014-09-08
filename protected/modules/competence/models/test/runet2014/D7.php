<?php
namespace competence\models\test\runet2014;

use competence\models\Question;

class D7 extends \competence\models\form\Textarea
{
    public function getPrev()
    {
        $test = $this->getQuestion()->getTest();
        $question = Question::model()->byCode('D2')->byTestId($test->Id)->find();
        $question->Test = $test;
        $result = $question->Test->getResult()->getQuestionResult($question);

        foreach ($result['value'] as $value) {
            if ($value !== 'not') {
                return parent::getPrev();
            }
        }

        $question = Question::model()->byCode('D2')->byTestId($this->getQuestion()->TestId)->find();
        $question->Test = $this->getQuestion()->getTest();
        return $question;
    }

}
