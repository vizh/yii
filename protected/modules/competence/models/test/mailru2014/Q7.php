<?php
namespace competence\models\test\mailru2014;

use competence\models\Question;

class Q7 extends \competence\models\form\Single
{
    public function getPrev()
    {
        $baseQuestion = Question::model()->byTestId($this->getQuestion()->TestId)->byCode('Q2')->find();
        $baseQuestion->setTest($this->getQuestion()->Test);
        $result = $baseQuestion->getResult();
        if ($result['value'] == 5) {
            return $baseQuestion;
        }

        return parent::getPrev();
    }

    public function getNext()
    {
        if ($this->value == 1 || $this->value == 2) {
            return Question::model()->byTestId($this->getQuestion()->TestId)->byCode('Q8_1')->find();
        } else {
            return Question::model()->byTestId($this->getQuestion()->TestId)->byCode('Q8_2')->find();
        }
    }
}
