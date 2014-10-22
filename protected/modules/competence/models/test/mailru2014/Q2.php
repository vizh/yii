<?php
namespace competence\models\test\mailru2014;

use competence\models\Question;

class Q2 extends \competence\models\form\Single
{
    public function getNext()
    {
        if ($this->value == 5) {
            return Question::model()->byTestId($this->getQuestion()->TestId)->byCode('Q7')->find();
        }
        return parent::getNext();
    }
}
