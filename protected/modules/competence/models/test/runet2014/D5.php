<?php
namespace competence\models\test\runet2014;

class D5 extends D4
{
    public function getNext()
    {
        if (!$this->getIsMarketParticipant()) {
            $question = Question::model()->byCode('D7')->byTestId($this->getQuestion()->TestId)->find();
            $question->Test = $this->getQuestion()->getTest();
            return $question;
        }
        return parent::getNext();
    }
}
