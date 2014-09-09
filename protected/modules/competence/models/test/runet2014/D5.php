<?php
namespace competence\models\test\runet2014;

use competence\models\Question;

class D5 extends D
{
    public function getTitle()
    {
        return sprintf(parent::getTitle(), $this->getSegment());
    }

    public function getNext()
    {
        if (!$this->getIsMarketParticipant($this->getQuestion()->Test)) {
            $question = Question::model()->byCode('D7')->byTestId($this->getQuestion()->TestId)->find();
            $question->Test = $this->getQuestion()->getTest();
            return $question;
        }
        return parent::getNext();
    }
}
