<?php
namespace competence\models\test\runet2016;

use competence\models\Question;
use competence\models\form\Input;

class B2 extends Input 
{
    protected function getBaseQuestionCode()
    {
        return 'A1';
    }

    public function getPrev()
    {
        $result = $this->getBaseQuestion()->getResult();
        $code = 'B1_'.$result['value'];
        return Question::model()->byTestId($this->getQuestion()->TestId)->byCode($code)->find();
    }

    public function getNext()
    {
        $result = $this->getBaseQuestion()->getResult();
        $code = 'B1_'.$result['value'];
        $question = Question::model()->byTestId($this->getQuestion()->TestId)->byCode($code)->find();
        $question->setTest($this->question->getTest());

        $result = $question->getResult();
        $code = 'C1_'.$result['value'][0];
        return Question::model()->byTestId($this->getQuestion()->TestId)->byCode($code)->find();
    }
}
