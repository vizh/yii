<?php
namespace competence\models\test\runet2016;

use competence\models\Question;
use competence\models\form\Single;

class A1 extends Single
{
    private $codes = [1 => 'B1_1', 2 => 'B1_2', 3 => 'B1_3', 4 => 'B1_4'];

    public function getNext()
    {
        $value = intval($this->value);
        $code = isset($this->codes[$value]) ? $this->codes[$value] : null;
        $question = null;
        if ($code !== null) {
            $question = Question::model()->byTestId($this->question->TestId)->byCode($code)->find();
        } else {
            $question = parent::getNext();
        }
        return $question;
    }
}
