<?php
namespace competence\models\test\mailru2014;

use competence\models\Question;

class Q7 extends \competence\models\form\Single
{
    public function getPrev()
    {
        $q2 = Question::model()->byTestId($this->getQuestion()->TestId)->byCode('Q2')->find();
        $q2->setTest($this->getQuestion()->Test);
        $resultQ2 = $q2->getResult();
        if ($resultQ2['value'] == 5) {
            return $q2;
        }

        $q2_1 = Question::model()->byTestId($this->getQuestion()->TestId)->byCode('Q2_1')->find();
        $q2_1->setTest($this->getQuestion()->Test);
        $resultQ2_1 = $q2_1->getResult();
        if ($resultQ2_1['value'] == 1) {
            return $q2_1;
        }

        return parent::getPrev();
    }

    public function getNext()
    {
        if ($this->value == 1 || $this->value == 2) {
            $q2_1 = Question::model()->byTestId($this->getQuestion()->TestId)->byCode('Q2_1')->find();
            $q2_1->setTest($this->getQuestion()->Test);
            $resultQ2_1 = $q2_1->getResult();

            if (isset($resultQ2_1['value']) && $resultQ2_1['value'] == 1) {
                return Question::model()->byTestId($this->getQuestion()->TestId)->byCode('Q8_1')->find();
            } else {
                return Question::model()->byTestId($this->getQuestion()->TestId)->byCode('Q9')->find();
            }
        } else {
            return Question::model()->byTestId($this->getQuestion()->TestId)->byCode('Q8_2')->find();
        }
    }
}
