<?php
namespace competence\models\test\runet2014;

use competence\models\Question;

class B1 extends \competence\models\form\Single
{
    private $codes = [1 => 'B2_1', 2 => 'B2_2', 3 => 'B2_3', 4 => 'B2_4'];

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
