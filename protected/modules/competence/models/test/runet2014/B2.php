<?php
namespace competence\models\test\runet2014;

use competence\models\Question;

class B2 extends \competence\models\form\Multiple
{
    protected $codes = [];

    public function getNext()
    {
        foreach ($this->codes as $value => $code) {
            if (in_array($value, $this->value)) {
                return Question::model()->byTestId($this->question->TestId)->byCode($code)->find();
            }
        }
        return parent::getNext();
    }
} 